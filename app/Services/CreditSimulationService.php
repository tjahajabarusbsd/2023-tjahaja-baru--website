<?php

namespace App\Services;

use App\Models\CreditTenor;

class CreditSimulationService
{
  /**
   * Ubah kolom price (varchar) menjadi integer rupiah.
   * Contoh: "36970000", "36.970.000", "Rp 36.970.000", "36970000.00" -> 36970000
   */
  public function parsePrice(string|int|float|null $price): int
  {
    $value = trim((string) $price);

    // buang desimal di belakang: ".00", ",00", ".5"
    $value = preg_replace('/[.,]\d{1,2}$/', '', $value);

    return (int) preg_replace('/\D/', '', $value);
  }

  /**
   * DP minimal (dibulatkan ke atas per 1.000).
   */
  public function minDp(int $otr): int
  {
    $percent = (float) config('credit.min_dp_percent');

    return (int) (ceil(($otr * $percent / 100) / 1000) * 1000);
  }

  /**
   * Biaya fidusia berdasarkan plafon (sesuai rumus Excel leasing).
   */
  public function fidusiaFee(int $plafon): int
  {
    foreach (config('credit.fidusia_tiers') as [$maxPlafon, $fee]) {
      if ($maxPlafon === null || $plafon <= $maxPlafon) {
        return (int) $fee;
      }
    }

    return 0;
  }

  /**
   * Total asuransi kendaraan (TLO) selama tenor + biaya tambahan.
   * Jumlah tahun: 1 sampai 12 bulan = 1 tahun, 13-24 = 2 tahun, 25-36 = 3 tahun, dst.
   * Excel (35 bulan): 415.888 + 353.505 + 311.916 + 25.000 = 1.106.309
   */
  public function vehicleInsurance(int $otr, int $months): int
  {
    $cfg = config('credit.vehicle_insurance');
    $factors = $cfg['year_factors'];
    $lastFactor = end($factors);
    $years = (int) ceil($months / 12);

    $firstYearPremium = (int) round($otr * (float) $cfg['first_year_rate'] / 100);
    $total = 0;

    for ($year = 1; $year <= $years; $year++) {
      $factor = (float) ($factors[$year] ?? $lastFactor);
      $total += (int) round($firstYearPremium * $factor);
    }

    return $total + (int) $cfg['extra_fee'];
  }

  public function calculate(int $otr, int $dp, CreditTenor $tenor): array
  {
    $months = $tenor->months;
    $principal = $otr - $dp;

    $vehicleInsurance = $this->vehicleInsurance($otr, $months);
    $adm = (int) config('credit.adm_fee');
    $provision = (int) round($principal * $tenor->provision_percent / 100);
    $lifeRate = $tenor->life_insurance_rate / 100;

    // Fidusia tergantung plafon, sedangkan plafon memuat fidusia (di Excel: iterasi).
    // Mulai dari tingkat terendah lalu naik sampai stabil.
    $fidusia = $this->fidusiaFee(0);

    for ($i = 0; $i < 10; $i++) {
      // Biaya di luar asuransi jiwa
      $base = $principal + $vehicleInsurance + $adm + $fidusia + $provision;

      // Asuransi jiwa = rate x plafon, sedangkan plafon sudah memuat asuransi jiwa.
      // Jadi: plafon = base / (1 - rate)
      $lifeInsurance = (int) round($base / (1 - $lifeRate) * $lifeRate);
      $plafon = $base + $lifeInsurance;

      $nextFidusia = $this->fidusiaFee($plafon);

      if ($nextFidusia === $fidusia) {
        break;
      }

      $fidusia = $nextFidusia;
    }

    // Bunga flat per tahun
    $totalPayment = $plafon * (1 + ($tenor->flat_rate / 100) * ($months / 12));

    // Cicilan dibulatkan ke atas per 1.000 (dari plafon sebelum pembulatan manual)
    $step = (int) config('credit.round_installment');
    $installment = (int) (ceil(round($totalPayment / $months, 4) / $step) * $step);

    return [
      'otr' => $otr,
      'dp' => $dp,
      'dp_percent' => round($dp / $otr * 100, 2),
      'months' => $months,
      'installment' => $installment,

      // rincian internal (tidak ditampilkan ke customer)
      'breakdown' => [
        'vehicle_insurance' => $vehicleInsurance,
        'life_insurance' => $lifeInsurance,
        'adm' => $adm,
        'fidusia' => $fidusia,
        'provision' => $provision,
        'total_cost' => $vehicleInsurance + $lifeInsurance + $adm + $fidusia + $provision,
        'plafon' => $plafon,
        'total_payment' => (int) round($totalPayment),
      ],
    ];
  }
}
