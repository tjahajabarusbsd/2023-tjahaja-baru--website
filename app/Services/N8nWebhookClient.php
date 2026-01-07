<?php

namespace App\Services;

use App\Models\BookingService;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Factories\N8nBookingPayloadFactory;

class N8nWebhookClient
{
  public function sendBooking(BookingService $booking): void
  {
    $payload = N8nBookingPayloadFactory::make($booking);

    Log::info('[N8N] Sending booking', $payload);

    $response = Http::timeout(5)
      ->acceptJson()
      ->withToken(config('services.n8n.token'))
      ->post(config('services.n8n.webhook'), $payload);

    Log::info('[N8N] Response', [
      'status' => $response->status(),
      'body' => $response->body(),
    ]);
  }
}
