<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\BookingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Helpers\ApiResponse;
use App\Models\NomorRangka;

class BookingServiceController extends Controller
{
    public function store(Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            return ApiResponse::error('Unauthorized', 401);
        }

        $request->validate([
            'motor_id'  => 'required|exists:nomor_rangkas,id',
            'dealer_id' => 'required|integer',
            'tanggal'   => 'required|date',
            'jam'       => 'required',
        ]);

        $motor = NomorRangka::where('id', $request->motor_id)
            ->where('user_public_id', $user->id)
            ->first();

        if (!$motor) {
            return ApiResponse::error('Motor ini tidak terdaftar atas nama Anda.', 403);
        }

        $booking_id = 'bkg' . rand(100, 999);

        $booking = BookingService::create([
            'user_id'    => $user->id,
            'motor_id'   => $request->motor_id,
            'booking_id' => $booking_id,
            'dealer_id'  => $request->dealer_id,
            'tanggal'    => $request->tanggal,
            'jam'        => $request->jam,
        ]);

        return ApiResponse::success('Booking berhasil diproses. Kami akan segera menghubungi Anda.', [
            'data'    => $booking
        ]);
    }
}
