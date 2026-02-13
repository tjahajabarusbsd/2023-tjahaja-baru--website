<?php

namespace App\Services\Booking;

use App\Models\BookingService;
use App\Models\Notification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Services\Notification\FcmService;

class BookingStatusNotifier
{
  public function notify(
    BookingService $booking,
    string $oldStatus,
    string $newStatus
  ): void {
    if ($oldStatus === $newStatus) {
      return;
    }

    $user = $booking->user;
    $motor = $booking->motor;

    if (!$user) {
      return;
    }

    DB::transaction(function () use ($user, $booking, $motor, $newStatus) {

      match ($newStatus) {

        'cancelled' => $this->storeNotification(
          $user->id,
          $booking->id,
          'Booking Servis Dibatalkan.',
          'Booking servis untuk motor ' . ($motor->nama_model ?? '-') . ' telah dibatalkan.'
        ),

        'confirmed', 'approved' => $this->storeNotification(
          $user->id,
          $booking->id,
          'Booking Servis Dikonfirmasi.',
          'Booking servis untuk motor ' . ($motor->nama_model ?? '-') . ' telah dikonfirmasi. Sampai jumpa di dealer!'
        ),

        'completed' => $this->storeNotification(
          $user->id,
          $booking->id,
          'Servis Selesai.',
          'Servis motor Anda telah selesai.'
        ),

        default => null,
      };
    });

    // 🔔 FCM setelah commit
    DB::afterCommit(function () use ($user, $newStatus, $motor) {
      if (!$user->fcm_token) {
        return;
      }

      app(FcmService::class)->send(
        $user->fcm_token,
        $this->title($newStatus),
        $this->message($newStatus, $motor)
      );
    });
  }

  protected function storeNotification(
    int $userId,
    int $bookingId,
    string $title,
    string $description
  ): void {
    Notification::create([
      'user_public_id' => $userId,
      'source_type' => BookingService::class,
      'source_id' => $bookingId,
      'category' => 'Booking Service',
      'title' => $title,
      'description' => $description,
      'is_read' => false,
    ]);
  }

  protected function title(string $status): string
  {
    return match ($status) {
      'cancelled' => 'Booking Servis Dibatalkan ❌',
      'confirmed', 'approved' => 'Booking Servis Dikonfirmasi ✅',
      'completed' => 'Servis Selesai ✅',
      default => 'Update Booking Servis',
    };
  }

  protected function message(string $status, $motor): string
  {
    $model = $motor->nama_model ?? '-';

    return match ($status) {
      'cancelled' => "Booking servis untuk motor {$model} telah dibatalkan.",
      'confirmed', 'approved' => "Booking servis untuk motor {$model} telah dikonfirmasi.",
      'completed' => "Servis untuk motor {$model} telah selesai.",
      default => "Status booking servis diperbarui.",
    };
  }
}
