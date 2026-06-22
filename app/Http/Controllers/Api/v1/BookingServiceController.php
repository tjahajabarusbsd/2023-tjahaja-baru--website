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

            // $csrfToken = $csrfResponse->json('token');
            // dd(
            //     $csrfResponse->body(),
            //     $csrfResponse->headers()
            // );
            if (!$csrfResponse->successful()) {
                Log::error('Failed to get CSRF token', ['status' => $csrfResponse->status(), 'body' => $csrfResponse->body()]);
                return ApiResponse::error('Gagal mendapatkan CSRF token dari Yamaha Motor', 500);
            }

            // DEBUG: Lihat struktur response CSRF
            // $csrfBody = $csrfResponse->json();
            // Log::info('CSRF Response structure', [
            //     'status' => $csrfResponse->status(),
            //     'headers' => $csrfResponse->headers(),
            //     'body' => $csrfBody,
            //     'raw_body' => $csrfResponse->body(),
            // ]);

            $csrfToken = $csrfResponse->json('token');

            Log::info('CSRF Token obtained', [
                'token_length' => strlen($csrfToken),
                'token_preview' => substr($csrfToken, 0, 30) . '...',
            ]);

            // 📝 SIMPAN KE DATABASE TERLEBIH DAHULU
            $booking = $creator->handle($request, $user);
            // DEBUG: Uncomment untuk melihat booking object
            // dd('Booking created:', $booking->toArray());
            Log::info('Booking saved to database', ['booking_id' => $booking->id, 'user_id' => $booking->user_id]);

            // 📤 SIAPKAN DATA UNTUK DIKIRIM KE YAMAHA
            $yamahaPayload = [
                'dealerCode' => optional($booking->dealer)->dealer_code ?? '9FP002',
                'targetDate' => Carbon::parse($booking->tanggal)->format('Ymd'),
                'targetTime' => str_replace(':', '', $booking->jam),
                'customerName' => $user->name,
                'mobilePhone' => $user->phone_number ?? '',
                'modelName' => optional($booking->motor)->nama_model ?? '',
                'plateNo' => optional($booking->motor)->nomor_plat ?? '',
                'serviceType' => $booking->menu_layanan ?? 'KSB',
                'memo' => $booking->permintaan_khusus ?? '',
            ];
            // DEBUG: Uncomment untuk melihat payload yang akan dikirim
            // dd('Yamaha Payload:', $yamahaPayload);
            Log::info('Yamaha payload prepared', $yamahaPayload);

            // 🚀 KIRIM KE API YAMAHA DEPACK
            Log::info('Attempting to send booking to Yamaha', [
                'url' => 'https://www.yamaha-motor.co.id/ajax/com/dpack/send-booking',
                'csrf_token_length' => strlen($csrfToken),
                'payload' => $yamahaPayload,
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

            // DEBUG: Uncomment untuk melihat response dari Yamaha
            // dd('Yamaha Response Debug', [
            //     'status' => $dpackResponse->status(),
            //     'headers' => $dpackResponse->headers(),
            //     'body' => $dpackResponse->json(),
            //     'raw_body' => $dpackResponse->body(),
            // ]);

            Log::info('Yamaha API response', [
                'status' => $dpackResponse->status(),
                'successful' => $dpackResponse->successful(),
                'response_body' => $dpackResponse->json(),
            ]);

            // 💾 UPDATE STATUS BOOKING BERDASARKAN RESPONSE DARI YAMAHA
            if ($dpackResponse->successful()) {
                $booking->update([
                    'status' => 'pending',
                    'external_status' => $dpackResponse->json('status') ?? 'sent_to_yamaha',
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
                        'yamaha_response' => $dpackResponse->json(),
                    ]
                );
            } else {
                // ⚠️ JIKA GAGAL DIKIRIM KE YAMAHA, UPDATE STATUS MENJADI PENDING
                $errorMessage = $dpackResponse->json('error') ?? $dpackResponse->json('message') ?? 'Unknown error';

                Log::error('Yamaha API request failed', [
                    'status' => $dpackResponse->status(),
                    'error_message' => $errorMessage,
                    'full_response' => $dpackResponse->json(),
                    'raw_body' => $dpackResponse->body(),
                ]);

                $booking->update([
                    'status' => 'pending',
                    'external_status' => 'failed_to_send',
                ]);

                return ApiResponse::error(
                    'Booking dibuat tetapi gagal dikirim ke Yamaha Motor. Error: ' . $errorMessage,
                    $dpackResponse->status(),
                    [
                        'booking' => [
                            'id' => $booking->id,
                            'booking_id' => $booking->booking_id,
                            'status' => $booking->status,
                        ],
                        'yamaha_error' => $dpackResponse->json(),
                        'debug_info' => [
                            'csrf_token_length' => strlen($csrfToken),
                            'api_url' => 'https://www.yamaha-motor.co.id/ajax/com/dpack/send-booking',
                        ],
                    ]
                );
            }

        } catch (\Exception $e) {
            Log::error('Exception in booking store function', [
                'error_message' => $e->getMessage(),
                'error_code' => $e->getCode(),
                'error_file' => $e->getFile(),
                'error_line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
            ]);

            return ApiResponse::error(
                'Terjadi kesalahan saat membuat booking: ' . $e->getMessage(),
                500,
                [
                    'error_details' => [
                        'message' => $e->getMessage(),
                        'file' => $e->getFile(),
                        'line' => $e->getLine(),
                    ],
                ]
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

        $booking->status = 'cancelled';
        $booking->save();

        return ApiResponse::success('Booking berhasil dibatalkan', $booking);
    }
}
