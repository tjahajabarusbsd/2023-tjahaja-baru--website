<?php

namespace App\Listeners;

use App\Events\DailyQuotaReached;
use App\Services\Notification\FcmService;
use Illuminate\Support\Facades\Log;

class SendDailyQuotaReachedNotification
{
  public function handle(DailyQuotaReached $event)
  {
    $qrCode = $event->qrCode;

    Log::info('Kuota harian QR code tercapai, broadcast dikirim', [
      'qrcode_id' => $qrCode->id,
      'kode' => $qrCode->kode,
      'nama_qrcode' => $qrCode->nama_qrcode,
      'promo' => $qrCode->promo->name,
      'merchant' => $qrCode->promo->merchant->title,
      'max_penggunaan_harian' => $qrCode->max_penggunaan_harian,
      'tanggal' => now()->toDateString(),
    ]);

    app(FcmService::class)->sendToTopic(
      'promo',
      $qrCode->promo->name,
      "Kuota harian sudah penuh, coba lagi besok."
    );
  }
}
