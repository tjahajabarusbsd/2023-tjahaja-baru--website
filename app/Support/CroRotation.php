<?php

namespace App\Support;

use Carbon\CarbonInterface;
use Illuminate\Support\Carbon;

/*
 * Nomor CRO untuk lead tanpa sales, bergantian tiap hari.
 *
 * Daftar nomor diambil dari NO_CRO di .env, dipisah koma:
 *   NO_CRO=628111111111,628222222222
 * Urutan di daftar = urutan giliran. Ganti hari mengikuti tengah malam WIB.
 */

class CroRotation
{
  // Hari ke-0 = nomor pertama di daftar
  private const EPOCH = '2024-01-01';

  private const TIMEZONE = 'Asia/Jakarta';

  /**
   * @return string[]
   */
  public static function numbers(): array
  {
    // Fallback ke env() dipertahankan sampai config/services.php diisi
    $raw = config('services.whatsapp.cro_numbers') ?? env('NO_CRO');

    return array_values(array_filter(array_map(
      fn($number) => str_replace('+', '', trim($number)),
      explode(',', (string) $raw)
    )));
  }

  public static function forDate(CarbonInterface $date): string
  {
    $numbers = self::numbers();
    $count = count($numbers);

    if ($count === 0) {
      return '';
    }

    $day = $date->copy()->setTimezone(self::TIMEZONE)->startOfDay();
    $epoch = Carbon::parse(self::EPOCH, self::TIMEZONE)->startOfDay();

    $daysSinceEpoch = intdiv($day->getTimestamp() - $epoch->getTimestamp(), 86400);

    // Rumus ini juga aman untuk tanggal sebelum EPOCH (hasil sisa bagi negatif)
    return $numbers[(($daysSinceEpoch % $count) + $count) % $count];
  }
}
