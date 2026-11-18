<?php

namespace App\Services\N8n;

use App\Models\BookingService;
use App\Services\N8n\N8nBookingPayloadFactory;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Psr\Log\LoggerInterface;
use Throwable;

class N8nWebhookClient
{
  /**
   * Semua log n8n ditulis ke channel `n8n` (storage/logs/n8n-YYYY-MM-DD.log).
   */
  private function log(): LoggerInterface
  {
    return Log::channel('n8n');
  }

  public function sendBooking(BookingService $booking): void
  {
    $payload = N8nBookingPayloadFactory::store($booking);
    // dd($payload);
    $this->log()->info('[N8N] Store booking payload', $payload);

    $response = Http::timeout(10)
      ->acceptJson()
      ->withToken(config('services.n8n.token'))
      ->post(config('services.n8n.webhook'), $payload);

    $this->log()->info('[N8N] Store booking response', [
      'status' => $response->status(),
      'body' => $response->json(),
    ]);

    if (!$response->successful()) {
      return;
    }

    $body = $response->json();

    if (($body['success'] ?? null) !== 'true') {
      return;
    }

    // ✅ UPDATE BOOKING YANG SAMA
    $booking->update([
      'service_schedule_id' => $body['serviceScheduleId'] ?? null,
      'serialized_product_id' => $body['serializedProductId'] ?? null,
      'external_status' => 'stored', // optional
    ]);
  }

  public function cekStatus(BookingService $booking)
  {
    $payload = N8nBookingPayloadFactory::cekStatus($booking);

    // Dipanggil tiap 5 menit per booking, jadi pakai debug
    // supaya tidak memenuhi log di production.
    $this->log()->debug('[N8N] Cek status payload', $payload);

    $response = Http::timeout(10)
      ->acceptJson()
      ->withToken(config('services.n8n.token'))
      ->post(config('services.n8n.webhook'), $payload);

    $this->log()->debug('[N8N] Cek status response', [
      'booking_id' => $booking->id,
      'status' => $response->status(),
      'body' => $response->json(),
    ]);

    if (!$response->successful()) {
      $this->log()->warning('[N8N] Cek status gagal', [
        'booking_id' => $booking->id,
        'http_status' => $response->status(),
      ]);
      return;
    }

    $body = $response->json();
    if (($body['success'] ?? null) !== 'true') {
      return;
    }

    $oldStatus = $booking->status;
    $updates = [];

    // Selalu sinkronkan id dari response; hanya tersimpan kalau nilainya berbeda.
    if (isset($body['serviceScheduleId'])) {
      $updates['service_schedule_id'] = $body['serviceScheduleId'];
    }

    if (isset($body['productId'])) {
      $updates['serialized_product_id'] = $body['productId'];
    }

    // Cek perubahan status external
    if (
      isset($body['status']) &&
      $body['status'] !== $booking->external_status
    ) {
      $updates['external_status'] = $body['status'];

      $mappedStatus = $this->mapExternalStatus($body['status']);

      if ($mappedStatus !== null) {
        $updates['status'] = $mappedStatus;
      } else {
        // Status tidak dikenal: jangan timpa kolom status dengan null.
        $this->log()->warning('[N8N] Status external tidak dikenal', [
          'booking_id' => $booking->id,
          'external_status' => $body['status'],
        ]);
      }
    }

    // fill() lalu isDirty() membandingkan nilai baru dengan nilai di database,
    // jadi nilai yang sama tidak dihitung sebagai perubahan.
    $booking->fill($updates);

    if (!$booking->isDirty()) {
      return;
    }

    $statusChanged = $booking->isDirty('status');

    $booking->save();
    $booking->refresh();

    // Notifikasi hanya dikirim kalau status benar-benar berubah.
    if ($statusChanged) {
      app(\App\Services\Booking\BookingStatusNotifier::class)
        ->notify(
          $booking,
          $oldStatus,
          $booking->status
        );

      $this->log()->info('[N8N] Status booking berubah dari dpack', [
        'booking_id' => $booking->id,
        'old_status' => $oldStatus,
        'new_status' => $booking->status,
      ]);
    }
  }

  public function cancel(BookingService $booking): bool
  {
    try {
      $payload = N8nBookingPayloadFactory::cancel($booking);
      $this->log()->info('[N8N] Cancel booking request', [
        'booking_id' => $booking->id,
        'user_id' => $booking->user_id,
        'action' => $payload['action'] ?? null,
      ]);

      $response = Http::timeout(10)
        ->acceptJson()
        ->withToken(config('services.n8n.token'))
        ->post(config('services.n8n.webhook'), $payload);

      $body = $response->json();

      if (!is_array($body)) {
        $body = [];
      }

      $this->log()->info('[N8N] Cancel booking response', [
        'booking_id' => $booking->id,
        'status' => $response->status(),
        'success' => $body['success'] ?? null,
      ]);

      if (!$response->successful()) {
        return false;
      }

      if (!in_array($body['success'] ?? null, [true, 'true', 1, '1'], true)) {
        return false;
      }

      $booking->update([
        'external_status' => 'cancelled',
        'status' => 'cancelled',
      ]);

      return true;
    } catch (Throwable $e) {
      $this->log()->error('[N8N] Cancel booking failed', [
        'booking_id' => $booking->id,
        'user_id' => $booking->user_id,
        'error_message' => $e->getMessage(),
      ]);

      return false;
    }
  }

  private function mapExternalStatus(?string $status): ?string
  {
    if (!$status) {
      return null;
    }

    return match (strtolower($status)) {
      'waiting' => 'pending',
      'approved' => 'confirmed',
      'progress' => 'progress',
      'done' => 'done',
      'cancelled' => 'cancelled',
      default => null,
    };
  }
}
