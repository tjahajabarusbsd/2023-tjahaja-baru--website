<?php

namespace App\Services\Notification;

use Kreait\Firebase\Factory;
use Illuminate\Support\Facades\Log;

class FcmService
{
  public function send($deviceToken, $title, $body, array $data = [])
  {
    if (!$deviceToken) {
      Log::warning('User tidak punya FCM token, notifikasi tidak dikirim.');
      return;
    }

    try {
      $factory = (new Factory)
        ->withServiceAccount(config('services.firebase.credentials.file'));

      $messaging = $factory->createMessaging();

      $payload = array_merge($data, [
        'title' => $title,
        'body' => $body,
      ]);

      $message = [
        'token' => $deviceToken,
        'data' => array_map('strval', $payload),
        'android' => [
          'priority' => 'high',
        ],
      ];

      $messaging->send($message);

      Log::info("FCM notification sent to token: {$deviceToken} | title: {$title}");
    } catch (\Exception $e) {
      Log::error("Gagal mengirim FCM notifikasi ke token {$deviceToken} | title: {$title} | error: " . $e->getMessage());
    }
  }

  public function sendToTopic($topic, $title, $body, array $data = [])
  {
    try {
      $factory = (new Factory)
        ->withServiceAccount(config('services.firebase.credentials.file'));

      $messaging = $factory->createMessaging();

      $payload = array_merge($data, [
        'title' => $title,
        'body' => $body,
      ]);

      $message = [
        'topic' => $topic,
        'data' => array_map('strval', $payload),
        'android' => [
          'priority' => 'high',
        ],
      ];

      $messaging->send($message);

      Log::info("FCM notification sent to topic: {$topic} | title: {$title}");
    } catch (\Exception $e) {
      Log::error("Gagal mengirim FCM topic: {$topic} | title: {$title} | error: " . $e->getMessage());
    }
  }
}
