<?php

namespace App\Services\Booking;

use App\Models\BookingService;
use RuntimeException;

class ActiveBookingException extends RuntimeException
{
  public function __construct(public BookingService $booking)
  {
    parent::__construct('User already has an active booking.');
  }
}
