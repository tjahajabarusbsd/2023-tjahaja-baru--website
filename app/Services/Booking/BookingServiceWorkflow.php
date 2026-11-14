<?php

namespace App\Services\Booking;

use App\Models\BookingService;
use App\Models\UserPublic;
use App\Services\BookingServiceCreator;
use App\Services\N8n\N8nWebhookClient;
use Exception;
use Illuminate\Support\Facades\Log;

class BookingServiceWorkflow
{
  public function __construct(
    private BookingServiceCreator $creator,
    private N8nWebhookClient $n8nClient
  ) {
  }

  public function create(UserPublic $user, array $data): BookingService
  {
    Log::info('Booking store request received', [
      'user_id' => $user->id,
      'motor_id' => $data['motor_id'],
      'dealer_id' => $data['dealer_id'],
      'tanggal' => $data['tanggal'],
      'jam' => $data['jam'],
      'menu_layanan' => $data['menu_layanan'],
    ]);

    $lastBooking = BookingService::where('user_id', $user->id)
      ->latest('id')
      ->first();

    if ($lastBooking && in_array($lastBooking->status, ['pending', 'confirmed', 'progress'], true)) {
      Log::info('Booking rejected - user still has active booking', [
        'user_id' => $user->id,
        'last_booking_id' => $lastBooking->id,
        'last_booking_status' => $lastBooking->status,
      ]);

      throw new ActiveBookingException($lastBooking);
    }

    $booking = $this->creator->handle($data, $user);

    Log::info('Booking saved to database', [
      'booking_id' => $booking->id,
      'booking_code' => $booking->booking_id,
      'user_id' => $booking->user_id,
      'status' => $booking->status,
    ]);

    if (!config('services.n8n.enabled')) {
      Log::info('N8n disabled - booking not sent to N8n', [
        'booking_id' => $booking->id,
        'user_id' => $user->id,
      ]);

      return $booking;
    }

    Log::info('Attempting to send booking to N8n', [
      'booking_id' => $booking->id,
      'user_id' => $user->id,
    ]);

    try {
      $this->n8nClient->sendBooking($booking);

      Log::info('Booking sent to N8n', [
        'booking_id' => $booking->id,
        'user_id' => $user->id,
      ]);
    } catch (Exception $e) {
      Log::error('Failed to send booking to N8n - booking already saved', [
        'booking_id' => $booking->id,
        'user_id' => $user->id,
        'error_message' => $e->getMessage(),
        'error_file' => $e->getFile(),
        'error_line' => $e->getLine(),
      ]);
    }

    return $booking;
  }
}
