<?php

namespace App\Services;

use App\Models\BookingService;
use App\Models\NomorRangka;
use App\Models\UserPublic;

class BookingServiceCreator
{
  public function handle(array $data, UserPublic $user): BookingService
  {
    $motor = NomorRangka::where('id', $data['motor_id'])
      ->where('user_public_id', $user->id)
      ->where('status_verifikasi', 'verified')
      ->firstOrFail();

    $bookingId = $this->generateBookingId();

    $booking = BookingService::create([
      'user_id' => $user->id,
      'motor_id' => $data['motor_id'],
      'booking_id' => $bookingId,
      'dealer_id' => $data['dealer_id'],
      'menu_layanan' => $data['menu_layanan'],
      'permintaan_khusus' => $data['permintaan_khusus'] ?? null,
      'tanggal' => $data['tanggal'],
      'jam' => $data['jam'],
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
