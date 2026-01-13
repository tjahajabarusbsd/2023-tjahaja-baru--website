<?php

namespace App\Services\N8n;

use App\Models\BookingService;
use App\Services\N8n\N8nBookingPayloadFactory;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;


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

    if (
      isset($body['serviceScheduleId']) &&
      $body['serviceScheduleId'] !== $booking->service_schedule_id
    ) {
      $updates['service_schedule_id'] = $body['serviceScheduleId'];
    }

    if (
      isset($body['serializedProductId']) &&
      $body['serializedProductId'] !== $booking->serialized_product_id
    ) {
      $updates['serialized_product_id'] = $body['serializedProductId'];
    }

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

    Log::info('[N8N] Booking updated from dpack', [
      'booking_id' => $booking->id,
      'changes' => $updates,
    ]);

  }

  // public function cekStatus(BookingService $booking): array
  // {
  //   $payload = N8nBookingPayloadFactory::cekStatus($booking);

  //   $response = Http::timeout(5)
  //     ->acceptJson()
  //     ->withToken(config('services.n8n.token'))
  //     ->post(config('services.n8n.webhook'), $payload);

  //   return [
  //     'status' => $response->status(),
  //     'body' => $response->json(),
  //   ];
  // }


  private function mapExternalStatus(?string $status): ?string
  {
    if (!$status) {
      return null;
    }

    return match (strtolower($status)) {
      'booking' => 'pending',
      'approved' => 'confirmed',
      'progress' => 'in_progress',
      'done' => 'done',
      'cancelled' => 'cancelled',
      default => null,
    };
  }

}
