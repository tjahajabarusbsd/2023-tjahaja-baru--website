<?php

namespace App\Services;

use App\Models\BookingService;
use App\Models\NomorRangka;
use App\Jobs\SendBookingToN8n;
use Carbon\Carbon;

class BookingServiceCreator
{
  public function handle($request, $user): BookingService
  {
    $motor = NomorRangka::where('id', $request->motor_id)
      ->where('user_public_id', $user->id)
      ->where('status_verifikasi', 'verified')
      ->firstOrFail();

    $bookingId = $this->generateBookingId();

    $booking = BookingService::create([
      'user_id' => $user->id,
      'motor_id' => $request->motor_id,
      'booking_id' => $bookingId,
      'dealer_id' => $request->dealer_id,
      'menu_layanan' => $request->menu_layanan,
      'permintaan_khusus' => $request->permintaan_khusus,
      'tanggal' => $request->tanggal,
      'jam' => $request->jam,
    ]);

    return $booking;
  }

  protected function generateBookingId(): string
  {
    $prefix = 'BKG' . now()->format('ym');

    $lastBooking = BookingService::where('booking_id', 'like', $prefix . '%')
        ->latest('id')
        ->first();

    $nextNumber = 1;

    if ($lastBooking) {
        $nextNumber = ((int) substr($lastBooking->booking_id, -4)) + 1;
    }

    return $prefix . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
  }
}
