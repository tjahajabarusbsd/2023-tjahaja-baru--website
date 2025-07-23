<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BookingServiceController extends Controller
{
    public function index()
    {
        // Logic to list all booking services
        return response()->json(['message' => 'List of booking services']);
    }
    public function show($id)
    {
        // Logic to show a specific booking service by ID
        return response()->json(['message' => 'Booking service details for ID: ' . $id]);
    }
    public function store(Request $request)
    {
        // Validasi input
        // $request->validate([
        //     'motor_id'  => 'required|string|exists:motors,id',
        //     'dealer_id' => 'required|string|exists:dealers,id',
        //     'tanggal'   => 'required|date|after_or_equal:today',
        //     'jam'       => 'required|date_format:H:i',
        // ]);

        // Simpan data booking
        // $booking = \App\Models\BookingServis::create([
        //     'motor_id'  => $request->motor_id,
        //     'dealer_id' => $request->dealer_id,
        //     'tanggal'   => $request->tanggal,
        //     'jam'       => $request->jam,
        // ]);

        // Buat kode booking seperti bkg001
        // $booking->kode_booking = 'bkg' . str_pad($booking->id, 3, '0', STR_PAD_LEFT);
        // $booking->save();

        // Kembalikan response
        // return response()->json([
        //     'status'  => 'success',
        //     'code'    => 200,
        //     'message' => 'Booking berhasil diproses. Kami akan segera menghubungi Anda untuk langkah selanjutnya.',
        //     'data'    => [
        //         'booking_id' => $booking->kode_booking,
        //         'motor_id'   => $booking->motor_id,
        //         'dealer_id'  => $booking->dealer_id,
        //         'tanggal'    => $booking->tanggal,
        //         'jam'        => $booking->jam,
        //     ]
        // ], 200);
        return response()->json([
            'status'  => 'success',
            'code'    => 200,
            'message' => 'Booking berhasil diproses. Kami akan segera menghubungi Anda untuk langkah selanjutnya.',
            'data'    => [
                'booking_id' => "bkg001",
                'motor_id'   => "mtr001",
                'dealer_id'  => "dlr001",
                // current date and time for demonstration
                'tanggal'    => date('Y-m-d'),
                'jam'        => "09:00",
            ]
        ], 200);
    }
}
