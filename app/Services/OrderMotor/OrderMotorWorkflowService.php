<?php

namespace App\Services\OrderMotor;

use App\Models\OrderMotor;

class OrderMotorWorkflowService
{
  public function __construct(
    protected OrderMotorPointService $pointService,
    protected OrderMotorNotificationService $notificationService
  ) {
  }

  public function process($orderBefore, $orderAfter, callable $sendFcm)
  {
    $old = $orderBefore->status;
    $new = $orderAfter->status;

    // Tidak ada perubahan status → tidak lakukan apa-apa
    if ($old === $new) {
      return true;
    }

    $user = $orderAfter->user;
    $model = $orderAfter->model;

    // === 1. STATUS COMPLETED → tambah poin ===
    if ($new === 'completed') {
      $this->pointService->awardPoints(
        order: $orderAfter,
        user: $user,
        points: 1000
      );
    }

    // === 2. KIRIM NOTIFIKASI (DB + FCM) ===
    $this->notificationService->sendStatusNotification(
      user: $user,
      order: $orderAfter,
      status: $new
    );

    return true;
  }
}
