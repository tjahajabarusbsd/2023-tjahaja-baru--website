<?php

namespace App\Services\Notification;

use Kreait\Firebase\Factory;
use Illuminate\Support\Facades\Log;

class FcmService
{
  public function send($deviceToken, $title, $body)
  {
    if (!$deviceToken) {
      Log::warning('User tidak punya FCM token, notifikasi tidak dikirim.');
      return;
    }

    try {
      $factory = (new Factory)
        ->withServiceAccount(config('services.firebase.credentials.file'));

      $messaging = $factory->createMessaging();

      $message = [
        'token' => $deviceToken,
        'notification' => [
          'title' => $title,
          'body' => $body,
        ],
        'android' => [
          'priority' => 'high',
          'notification' => [
            'sound' => 'default',
          ],
        ],
      ];

      $messaging->send($message);

      Log::info("FCM notification sent to token: {$deviceToken}");
    } catch (\Exception $e) {
      Log::error('Gagal mengirim FCM notifikasi: ' . $e->getMessage());
    }
  }

  public function sendToTopic($topic, $title, $body)
  {
    try {
      $factory = (new Factory)
        ->withServiceAccount(config('services.firebase.credentials.file'));

      $messaging = $factory->createMessaging();

      $message = [
        'topic' => $topic, // 🔥 ini bedanya (bukan token)
        'notification' => [
          'title' => $title,
          'body' => $body,
        ],
        'android' => [
          'priority' => 'high',
          'notification' => [
            'sound' => 'default',
          ],
        ],
      ];

      $messaging->send($message);

      Log::info("FCM notification sent to topic: {$topic}");
    } catch (\Exception $e) {
      Log::error('Gagal mengirim FCM topic: ' . $e->getMessage());
    }
  }
}
