<?php

namespace App\Factories;

use App\Models\BookingService;
use Carbon\Carbon;

class N8nBookingPayloadFactory
{
  public static function make(BookingService $booking): array
  {
    $booking->loadMissing(['user', 'motor', 'dealer']);

    return [
      'type' => 'bookingServis',
      'pointInduk' => $booking->dealer->kode_dealer ?? '',
      'data' => [
        [
          'reservationDate' => Carbon::parse($booking->tanggal)->format('Ymd'),
          'reservationTime' => Carbon::parse($booking->jam)->format('H:i'),
          'customerName' => $booking->user->name ?? '',
          'frameNo' => $booking->motor->nomor_rangka ?? '',
          'mobilePhone' => $booking->user->phone_number ?? '',
          'brand' => 'C065YAMAHA',          // hardcode sesuai kebutuhan
          'plateNo' => $booking->motor->nomor_plat ?? '',
          'memo' => 'Melalui TB ONE',       // hardcode
        ]
      ]
    ];
  }
}
