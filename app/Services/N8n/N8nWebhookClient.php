<?php

namespace App\Services\N8n;

use App\Models\BookingService;
use App\Services\N8n\N8nBookingPayloadFactory;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Services\Notification\FcmService;

class N8nWebhookClient
{
  public function sendBooking(BookingService $booking): void
  {
    $payload = N8nBookingPayloadFactory::store($booking);
    // dd($payload);
    Log::info('[N8N] Store booking payload', $payload);

    $response = Http::timeout(10)
      ->acceptJson()
      ->withToken(config('services.n8n.token'))
      ->post(config('services.n8n.webhook'), $payload);

    Log::info('[N8N] Store booking response', [
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
    Log::info('[N8N] Cek status payload', $payload);

    $response = Http::timeout(10)
      ->acceptJson()
      ->withToken(config('services.n8n.token'))
      ->post(config('services.n8n.webhook'), $payload);

    Log::info('[N8N] Cek status response', [
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

    // 🔍 Bandingkan data lama vs baru
    $updates = [];
    $oldStatus = $booking->status;

    // ✅ Selalu update service_schedule_id dan serialized_product_id jika ada di response
    if (isset($body['serviceScheduleId'])) {
      $updates['service_schedule_id'] = $body['serviceScheduleId'];
    }

    if (isset($body['productId'])) {
      $updates['serialized_product_id'] = $body['productId'];
    }

    // 🔍 Cek perubahan status external
    if (
      isset($body['status']) &&
      $body['status'] !== $booking->external_status
    ) {
      $updates['external_status'] = $body['status'];
      $updates['status'] = $this->mapExternalStatus($body['status']);
    }

    // ⛔ TIDAK ADA PERUBAHAN → STOP
    if (empty($updates)) {
      Log::info('[N8N] No booking status changes', [
        'booking_id' => $booking->id,
      ]);
      return;
    }

    // ✅ ADA PERUBAHAN → UPDATE
    $booking->update($updates);
    $booking->refresh();

    app(\App\Services\Booking\BookingStatusNotifier::class)
      ->notify(
        $booking,
        $oldStatus,
        $booking->status
      );

    Log::info('[N8N] Booking updated from dpack', [
      'booking_id' => $booking->id,
      'old_status' => $oldStatus,
      'new_status' => $booking->status,
    ]);
  }

  private function mapExternalStatus(?string $status): ?string
  {
    if (!$status) {
      return null;
    }

    return match (strtolower($status)) {
      'Waiting' => 'pending',
      'Approved' => 'confirmed',
      'progress' => 'progress',
      'done' => 'done',
      'Cancelled' => 'cancelled',
      default => null,
    };
  }

}
