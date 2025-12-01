<?php

namespace App\Services\OrderMotor;

use App\Models\ActivityLog;
use App\Models\UserPublicProfile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class OrderMotorPointService
{
  public function awardPoints($order, $user, int $points): void
  {
    DB::transaction(function () use ($order, $user, $points) {

      // Prevent double reward
      $alreadyGiven = ActivityLog::where('source_type', get_class($order))
        ->where('source_id', $order->id)
        ->where('type', 'Order')
        ->where('points', '>=', $points)
        ->exists();

      if ($alreadyGiven) {
        Log::info("Order $order->id already awarded.");
        return;
      }

      // Activity log
      ActivityLog::create([
        'user_public_id' => $order->user_public_id,
        'source_type' => get_class($order),
        'source_id' => $order->id,
        'type' => 'Order',
        'title' => 'Order Motor Selesai',
        'description' => 'Order motor ' . $order->model . ' selesai.',
        'points' => $points,
        'activity_date' => now(),
      ]);

      // Update points safely with lock
      $profile = UserPublicProfile::where('user_public_id', $order->user_public_id)
        ->lockForUpdate()
        ->first();

      if ($profile) {
        $profile->increment('total_points', $points);
        $profile->increment('lifetime_points', $points);
      }
    });
  }
}
