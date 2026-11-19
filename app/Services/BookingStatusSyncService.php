<?php

namespace App\Services;

use App\Models\BookingService;
use App\Services\N8n\N8nWebhookClient;
use Illuminate\Support\Facades\Log;
use Throwable;

class BookingStatusSyncService
{
  public function syncLatestForUser(int $userId): void
  {
    $booking = BookingService::with('motor')
      ->where('user_id', $userId)
      ->whereIn('status', ['pending', 'booking', 'confirmed'])
      ->latest()
      ->first();
    // dd($booking);
    if ($booking) {
      $this->syncByBooking($booking);
    }
  }

  /**
   * Sinkronkan satu booking. Tidak pernah melempar exception,
   * supaya satu booking bermasalah tidak menghentikan booking lain
   * (command) dan tidak membuat endpoint index() error 500.
   */
  public function syncByBooking(BookingService $booking): void
  {
    try {
      if (!$booking->motor?->nomor_plat || !$booking->motor?->nomor_rangka) {
        Log::channel('n8n')->warning('[N8N] Skip cek status, data pooling belum lengkap', [
          'booking_id' => $booking->booking_id,
        ]);
        return;
      }

      app(N8nWebhookClient::class)->cekStatus($booking);
    } catch (Throwable $e) {
      Log::channel('n8n')->error('[N8N] Sync status booking gagal', [
        'booking_id' => $booking->id,
        'error' => $e->getMessage(),
        'file' => $e->getFile(),
        'line' => $e->getLine(),
      ]);
    }
  }
}
