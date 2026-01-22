<?php

namespace App\Services;

use App\Models\BookingService;
use App\Services\N8n\N8nWebhookClient;
use Illuminate\Support\Facades\Log;

class BookingStatusSyncService
{
  public function syncLatestForUser(int $userId): void
  {
    $booking = BookingService::where('user_id', $userId)
      ->whereIn('status', ['pending', 'booking', 'confirmed'])
      ->latest()
      ->first();
    // dd($booking);
    if ($booking) {
      $this->syncByBooking($booking);
    }
  }

  public function syncByBooking(BookingService $booking): void
  {
    if (!$booking->service_schedule_id || !$booking->serialized_product_id) {
      Log::warning('[N8N] Skip cek status, data pooling belum lengkap', [
        'booking_id' => $booking->booking_id,
      ]);
      return;
    }

    app(N8nWebhookClient::class)->cekStatus($booking);
  }
}
