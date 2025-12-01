<?php

namespace App\Services\Notification;

use App\Models\Notification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class NotificationService
{
  public function createDB($user, $source, string $title, string $description)
  {
    Notification::create([
      'user_public_id' => $user->id,
      'source_type' => get_class($source),
      'source_id' => $source->id,
      'title' => $title,
      'description' => $description,
      'is_read' => false,
    ]);
  }

  public function sendFCM($user, string $title, string $body, callable $sender)
  {
    if (!$user || !$user->fcm_token)
      return;

    DB::afterCommit(function () use ($user, $title, $body, $sender) {
      try {
        $sender($user->fcm_token, $title, $body);
      } catch (\Throwable $e) {
        Log::error("FCM error: " . $e->getMessage());
      }
    });
  }
}
