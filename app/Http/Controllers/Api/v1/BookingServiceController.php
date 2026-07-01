<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Services\BookingServiceCreator;
use App\Services\BookingStatusSyncService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Helpers\ApiResponse;
use App\Models\BookingService;
use App\Models\NomorRangka;
use App\Models\Notification;
use App\Http\Requests\BookingServiceRequest;
use App\Models\Dealer;
use App\Services\N8n\N8nWebhookClient;
use GuzzleHttp\Cookie\CookieJar;

class BookingServiceController extends Controller
{
    public function index(BookingStatusSyncService $syncService)
    {
        $user = Auth::user();

        // 🔁 SYNC STATUS SAAT MENU DIBUKA
        if (config('services.n8n.enabled')) {
            $syncService->syncLatestForUser($user->id);
        }

        // 🔽 AMBIL DATA TERBARU
        $bookings = BookingService::with('dealer', 'motor')
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        $formatted = $bookings->map(function ($booking) {
            return [
                'id' => $booking->id,
                'booking_id' => $booking->booking_id,
                'dealer' => optional($booking->dealer)->name_dealer,
                'motor' => optional($booking->motor)->nomor_rangka,
                'model' => optional($booking->motor)->nama_model,
                'plat' => optional($booking->motor)->nomor_plat,
                'tanggal' => $booking->tanggal,
                'jam' => $booking->jam,
                'status' => $booking->status,
                'created_at' => $booking->created_at->toDateTimeString(),
            ];
        });

        return ApiResponse::success(
            'Daftar booking servis berhasil diambil',
            $formatted
        );
    }

    /*
    // ❌ FUNGSI STORE LAMA - SUDAH DI-COMMENT
    // Fungsi ini digunakan untuk membuat booking servis dengan menggunakan BookingServiceCreator
    // dan mengirim data ke N8n webhook
    public function store(
        BookingServiceRequest $request,
        BookingServiceCreator $creator,
        N8nWebhookClient $n8nClient
    ) {
        $user = Auth::user();

        $booking = $creator->handle($request, $user);

        // optional: bisa dimatikan via env
        if (config('services.n8n.enabled')) {
            $n8nClient->sendBooking($booking);
        }

        return ApiResponse::success(
            'Booking servis berhasil dibuat',
            [
                'id' => $booking->id,
                'user_id' => $booking->user_id,
                'motor_id' => $booking->motor_id,
                'booking_id' => $booking->booking_id,
                'dealer_id' => $booking->dealer_id,
                'tanggal' => $booking->tanggal,
                'menu_layanan' => $booking->menu_layanan,
                'permintaan_khusus' => $booking->permintaan_khusus,
                'jam' => $booking->jam,
            ]
        );
    }
    */

    // ✅ FUNGSI STORE BARU - MENGIRIM KE API YAMAHA DEPACK
    /**
     * Store booking service dan kirim ke API Yamaha Motor
     * 
     * @param Request $request
     * @param BookingServiceCreator $creator
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request, BookingServiceCreator $creator)
    {
        try {
            $user = Auth::user();

            $cookieJar = new CookieJar();

            // 🔑 AMBIL CSRF TOKEN DARI API YAMAHA
            $csrfResponse = Http::withOptions([
                'cookies' => $cookieJar,
            ])->get(
                'https://www.yamaha-motor.co.id/ajax/com/csrf-token'
            );

            if (!$csrfResponse->successful()) {
                Log::error('Failed to get CSRF token', [
                    'status' => $csrfResponse->status(),
                    'user_id' => $user->id,
                ]);
                return ApiResponse::error('Kesalahan pada server', 500);
            }

            $csrfToken = $csrfResponse->json('token');

            Log::info('CSRF Token obtained', [
                'token_length' => strlen($csrfToken),
                'token_preview' => substr($csrfToken, 0, 30) . '...',
                'user_id' => $user->id,
            ]);

            // 📤 SIAPKAN DATA UNTUK DIKIRIM KE YAMAHA (BELUM SIMPAN KE DB)
            // Buat booking object sementara untuk mempersiapkan payload
            $bookingData = $request->all();
            $bookingData['user_id'] = $user->id;
            $motor = NomorRangka::find($bookingData['motor_id']);
            $dealer = Dealer::find($bookingData['dealer_id']);

            $yamahaPayload = [
                'dealerCode' => $dealer->dealer_code ?? '9FP002',
                'targetDate' => Carbon::parse($bookingData['tanggal'])->format('Ymd'),
                'targetTime' => str_replace(':', '', $bookingData['jam']),
                'customerName' => $user->name,
                'mobilePhone' => $user->phone_number ?? '',
                'modelName' => $motor->nama_model ?? '',
                'plateNo' => $motor->nomor_plat ?? '',
                'serviceType' => $bookingData['menu_layanan'] ?? 'KSB',
                'memo' => $bookingData['permintaan_khusus'] ?? '',
            ];

            Log::info('Yamaha payload prepared', [
                'payload' => $yamahaPayload,
                'user_id' => $user->id,
            ]);

            // 🚀 KIRIM KE API YAMAHA DEPACK TERLEBIH DAHULU
            Log::info('Attempting to send booking to Yamaha', [
                'url' => 'https://www.yamaha-motor.co.id/ajax/com/dpack/send-booking',
                'csrf_token_length' => strlen($csrfToken),
                'payload' => $yamahaPayload,
                'user_id' => $user->id,
            ]);

            $dpackResponse = Http::withOptions([
                'cookies' => $cookieJar,
            ])->withHeaders([
                'Accept' => 'application/json, text/javascript, */*; q=0.01',
                'x-csrf-token' => $csrfToken,
            ])->post(
                'https://www.yamaha-motor.co.id/ajax/com/dpack/send-booking',
                $yamahaPayload
            );

            $responseStatus = $dpackResponse->status();
            $isSuccessful = $dpackResponse->successful();
            $responseBody = $dpackResponse->json();

            Log::info('Yamaha API response', [
                'status' => $responseStatus,
                'successful' => $isSuccessful,
                'response_body' => $responseBody,
                'user_id' => $user->id,
            ]);

            // ✅ KONDISI SUKSES: Status 2xx (200-299)
            // BARU SIMPAN KE DATABASE JIKA YAMAHA API BERHASIL
            if ($isSuccessful && $responseStatus >= 200 && $responseStatus < 300) {
                $booking = $creator->handle($request, $user);

                $booking->update([
                    'status' => 'pending',
                    'external_status' => $responseBody['status'] ?? 'Waiting',
                ]);

                Log::info('Booking saved to database after successful Yamaha API response', [
                    'booking_id' => $booking->id,
                    'user_id' => $booking->user_id,
                ]);

                return ApiResponse::success(
                    'Booking servis berhasil dibuat dan dikirim ke Yamaha Motor',
                    [
                        'id' => $booking->id,
                        'user_id' => $booking->user_id,
                        'motor_id' => $booking->motor_id,
                        'booking_id' => $booking->booking_id,
                        'dealer_id' => $booking->dealer_id,
                        'tanggal' => $booking->tanggal,
                        'menu_layanan' => $booking->menu_layanan,
                        'permintaan_khusus' => $booking->permintaan_khusus,
                        'jam' => $booking->jam,
                        'status' => $booking->status,
                        'yamaha_response' => $responseBody,
                    ]
                );
            }

            // ❌ KONDISI GAGAL: Status 4xx atau 5xx
            // JANGAN SIMPAN KE DATABASE, HANYA LOG DETAIL ERROR
            if (!$isSuccessful || $responseStatus >= 400) {
                // Ekstrak error message dari berbagai format respons
                $errorMessage = null;

                if (is_array($responseBody)) {
                    $errorMessage = $responseBody['error'] ?? $responseBody['message'] ?? $responseBody['msg'] ?? null;
                } elseif (is_string($responseBody)) {
                    $errorMessage = $responseBody;
                }

                $errorMessage = $errorMessage ?? 'Unknown error from Yamaha API';

                Log::error('Yamaha API request failed - booking NOT saved to database', [
                    'status' => $responseStatus,
                    'error_message' => $errorMessage,
                    'full_response' => $responseBody,
                    'user_id' => $user->id,
                    'payload_sent' => $yamahaPayload,
                ]);

                return ApiResponse::error(
                    'Kesalahan pada server',
                    500
                );
            }

            // ⚠️ KONDISI TIDAK TERDUGA (Fallback)
            Log::warning('Yamaha API response in undefined state - booking NOT saved', [
                'status' => $responseStatus,
                'successful' => $isSuccessful,
                'response_body' => $responseBody,
                'user_id' => $user->id,
            ]);

            return ApiResponse::error(
                'Kesalahan pada server',
                500
            );
        } catch (\Exception $e) {
            Log::error('Exception in booking store function - booking NOT saved', [
                'error_message' => $e->getMessage(),
                'error_file' => $e->getFile(),
                'error_line' => $e->getLine(),
                'user_id' => Auth::id(),
            ]);

            return ApiResponse::error(
                'Kesalahan pada server',
                500
            );
        }
    }

    public function batal(Request $request)
    {
        $request->validate([
            'booking_id' => 'required|exists:booking_services,id',
        ]);

        $user = Auth::user();
        $booking = BookingService::where('id', $request->booking_id)
            ->where('user_id', $user->id)
            ->where('status', 'pending')
            ->first();

        if (!$booking) {
            return ApiResponse::error('Booking tidak ditemukan atau tidak dapat dibatalkan.', 404);
        }

        app(N8nWebhookClient::class)->cancel($booking);

        $booking->status = 'cancelled';
        $booking->save();

        return ApiResponse::success('Booking berhasil dibatalkan', $booking);
    }
}
