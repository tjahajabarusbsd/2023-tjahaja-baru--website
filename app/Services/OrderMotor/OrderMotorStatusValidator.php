<?php

namespace App\Services\OrderMotor;

use Illuminate\Support\Facades\Log;

class OrderMotorStatusValidator
{
  protected array $allowedTransitions = [
    'pending' => ['confirmed', 'cancelled'],
    'confirmed' => ['completed', 'cancelled'],
    'completed' => [],
    'cancelled' => [],
  ];

  public function validate(string $oldStatus, string $newStatus): bool
  {
    if (!isset($this->allowedTransitions[$oldStatus])) {
      return false;
    }

    return in_array($newStatus, $this->allowedTransitions[$oldStatus]);
  }
}
