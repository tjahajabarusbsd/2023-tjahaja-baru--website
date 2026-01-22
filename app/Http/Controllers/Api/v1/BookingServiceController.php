<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Services\BookingServiceCreator;
use App\Services\BookingStatusSyncService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Helpers\ApiResponse;
use App\Models\BookingService;
use App\Models\NomorRangka;
use App\Models\Notification;
use App\Http\Requests\BookingServiceRequest;
use App\Services\N8n\N8nWebhookClient;

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
