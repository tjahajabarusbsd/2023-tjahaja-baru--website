<?php

namespace App\Services\OrderMotor;

use App\Services\Notification\NotificationService;
use App\Services\Notification\FcmService;

class OrderMotorNotificationService
{
  public function __construct(
    protected NotificationService $notificationService,
    protected FcmService $fcm
  ) {
  }

  /**
   * Kirim notifikasi DB + FCM untuk status order motor.
   */
  public function sendStatusNotification($user, $order, string $status): void
  {
    if (!$user) {
      return;
    }

    // Mapping judul & pesan notifikasi
    [$title, $message] = $this->buildMessage($status, $order);

    if (!$title || !$message) {
      return; // status tidak dikenali, tidak kirim notifikasi
    }

    // 1. Simpan ke DB
    $this->notificationService->createDB(
      user: $user,
      source: $order,
      title: $title,
      description: $message
    );

    // 2. Kirim FCM setelah DB sukses commit
    $this->notificationService->sendFCM(
      user: $user,
      title: $title,
      body: $message,
      sender: fn($token, $t, $b) => $this->fcm->send($token, $t, $b)
    );
  }


  /**
   * Mapping pesan berdasarkan status
   */
  protected function buildMessage(string $status, $order): array
  {
    return match ($status) {
      'confirmed' => [
        'Order Motor Dikonfirmasi',
        "Order motor {$order->model} Anda telah dikonfirmasi.",
      ],
      'cancelled' => [
        'Order Motor Dibatalkan',
        "Order motor {$order->model} Anda telah dibatalkan.",
      ],
      'completed' => [
        'Order Motor Selesai',
        "Order motor {$order->model} telah selesai diproses.",
      ],
      default => [null, null],
    };
  }
}
