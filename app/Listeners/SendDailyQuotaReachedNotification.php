<?php

namespace App\Listeners;

use App\Events\DailyQuotaReached;
use App\Services\Notification\FcmService;

class SendDailyQuotaReachedNotification
{
  public function handle(DailyQuotaReached $event)
  {
    $qrCode = $event->qrCode;

    app(FcmService::class)->sendToTopic(
      'promo',
      'Kuota Harian Penuh',
      "Kode {$qrCode->nama_qrcode} sudah mencapai batas penggunaan hari ini. Coba lagi besok."
    );
  }
}
