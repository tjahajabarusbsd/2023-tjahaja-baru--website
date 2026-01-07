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
      'tanggal' => $request->tanggal,
      'jam' => $request->jam,
    ]);

    return $booking;
  }

  protected function generateBookingId(): string
  {
    $year = Carbon::now()->format('y');
    $month = Carbon::now()->format('m');

    $count = BookingService::whereYear('created_at', now()->year)
      ->whereMonth('created_at', now()->month)
      ->count() + 1;

    return sprintf("BKG%s%s%04d", $year, $month, $count);
  }
}
