<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Helpers\ApiResponse;
use App\Models\BookingService;
use App\Models\NomorRangka;
use App\Models\Notification;
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
                'dealer' => $booking->dealer ? $booking->dealer->name_dealer : '',
                'motor' => $booking->motor ? $booking->motor->nomor_rangka : '',
                'model' => $booking->motor ? $booking->motor->nama_model : '',
                'plat' => $booking->motor ? $booking->motor->nomor_plat : '',
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

        $motor = NomorRangka::where('id', $request->motor_id)
            ->where('user_public_id', $user->id)
            ->where('status_verifikasi', 'verified')
            ->first();

        if (!$motor) {
            return ApiResponse::error('Motor ini tidak terdaftar atas nama Anda.', 403);
        }

        // Ambil tahun & bulan
        $year = Carbon::now()->format('y');
        $month = Carbon::now()->format('m');

        // Hitung order bulan ini
        $countThisMonth = BookingService::whereYear('created_at', Carbon::now()->year)
            ->whereMonth('created_at', Carbon::now()->month)
            ->count() + 1;

        // Contoh: BKG25090001
        $booking_id = sprintf("BKG%s%s%04d", $year, $month, $countThisMonth);

        $booking = BookingService::create([
            'user_id' => $user->id,
            'motor_id' => $request->motor_id,
            'booking_id' => $booking_id,
            'dealer_id' => $request->dealer_id,
            'tanggal' => $request->tanggal,
            'jam' => $request->jam,
        ]);

        Notification::create([
            'user_public_id' => $user->id,
            'source_type' => BookingService::class,
            'source_id' => $booking->id,
            'title' => 'Booking servis berhasil.',
            'description' => "Servis motor Anda telah berhasil dan sedang diproses",
            'is_read' => false,
        ]);

        return ApiResponse::success('Booking berhasil diproses. Kami akan segera menghubungi Anda.', $booking);
    }
}
