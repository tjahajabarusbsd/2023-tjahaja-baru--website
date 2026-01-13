<?php

namespace App\Services\N8n;

use App\Models\BookingService;

class N8nBookingPayloadFactory
{
  public static function store(BookingService $booking): array
  {
    $booking->load(['user', 'motor', 'dealer']);

    return [
      'type' => 'bookingServis',
      'pointInduk' => $booking->dealer->kode_dealer,
      'action' => 'Store',
      'data' => [
        [
          'reservationDate' => now()->parse($booking->tanggal)->format('Ymd'),
          'reservationTime' => $booking->jam,
          'customerName' => $booking->user->name ?? '',
          'frameNo' => $booking->motor->nomor_rangka ?? '',
          'mobilePhone' => $booking->user->phone_number ?? '',
          'brand' => 'C065YAMAHA',
          'plateNo' => $booking->motor->nomor_plat ?? '',
          'memo' => 'Booking servis dari aplikasi',
          'serviceContent' => 'KSB',
          'serviceScheduleId' => $booking->service_schedule_id ?? null,
          'serializedProductId' => $booking->serialized_product_id ?? null,
        ]
      ]
    ];
  }

  public static function cekStatus(BookingService $booking): array
  {
    $booking->load(['user', 'motor', 'dealer']);

    return [
      'type' => 'bookingServisCek',
      'pointInduk' => $booking->dealer->kode_dealer,
      'action' => 'Check',
      'data' => [
        [
          'reservationDate' => now()->parse($booking->tanggal)->format('Ymd'),
          'reservationTime' => $booking->jam,
          'customerName' => $booking->user->name ?? '',
          'frameNo' => $booking->motor->nomor_rangka ?? '',
          'mobilePhone' => $booking->user->phone_number ?? '',
          'brand' => 'C065YAMAHA',
          'plateNo' => $booking->motor->nomor_plat ?? '',
          'memo' => 'Booking servis dari aplikasi',
          'serviceContent' => 'KSB',
          'serviceScheduleId' => $booking->service_schedule_id,
          'serializedProductId' => $booking->serialized_product_id,
        ]
      ]
    ];
  }


}
