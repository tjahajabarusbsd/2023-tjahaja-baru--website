<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Helpers\ApiResponse;
use App\Models\BookingService;
use App\Models\NomorRangka;
use App\Models\ActivityLog;
use App\Http\Requests\BookingServiceRequest;

class BookingServiceController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $bookings = BookingService::with('dealer', 'motor')
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        $formatted = $bookings->map(function ($booking) {
            return [
                'id' => $booking->id,
                'booking_id' => $booking->booking_id,
                'dealer' => $booking->dealer ? $booking->dealer->name_dealer : null,
                'motor' => $booking->motor ? $booking->motor->nomor_rangka : null,
                'tanggal' => $booking->tanggal,
                'jam' => $booking->jam,
                'status' => $booking->status,
                'created_at' => $booking->created_at->toDateTimeString(),
            ];
        });

        return ApiResponse::success('Daftar booking servis berhasil diambil', $formatted);
    }

    public function store(BookingServiceRequest $request)
    {
        $user = Auth::user();

        if (!$user) {
            return ApiResponse::error('Unauthorized', 401);
        }

        $motor = NomorRangka::where('id', $request->motor_id)
            ->where('user_public_id', $user->id)
            ->first();

        if (!$motor) {
            return ApiResponse::error('Motor ini tidak terdaftar atas nama Anda.', 403);
        }

        // Generate booking ID unik
        $booking_id = 'bkg-' . time() . rand(100, 999);

        $booking = BookingService::create([
            'user_id' => $user->id,
            'motor_id' => $request->motor_id,
            'booking_id' => $booking_id,
            'dealer_id' => $request->dealer_id,
            'tanggal' => $request->tanggal,
            'jam' => $request->jam,
        ]);


        // Simpan ke activity log
        ActivityLog::create([
            'user_public_id' => $user->id,
            'source_type' => BookingService::class,
            'source_id' => $booking->id,
            'type' => 'services',
            'title' => 'Servis telah dipesan',
            'description' => 'Booking servis untuk motor ' . $motor->nomor_rangka,
            'points' => 0, // belum dapat poin karena belum completed
            'activity_date' => now(),
        ]);

        return ApiResponse::success('Booking berhasil diproses. Kami akan segera menghubungi Anda.', $booking);
    }
}
