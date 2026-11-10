<?php

return [
  // DP minimal dalam persen dari OTR (SESUAIKAN dengan aturan leasing/BPR)
  'min_dp_percent' => 10,

  // Biaya ADM (sama di semua contoh Excel)
  'adm_fee' => 200000,

  // Biaya fidusia berdasarkan PLAFON (rumus dari Excel leasing).
  // Format: [plafon maksimal (termasuk), biaya]. null = tanpa batas.
  'fidusia_tiers' => [
    [25000000, 170000],
    [50000000, 200000],
    [250000000, 450000],
    [500000000, 750000],
    [null, 1500000],
  ],

  // Asuransi kendaraan TLO
  'vehicle_insurance' => [
    // Tahun 1 = 1,76% x OTR (23.630.000 -> 415.888)
    'first_year_rate' => 1.76,

    // Premi tahun ke-N = premi tahun 1 x faktor.
    // Dari Excel: tahun 2 = 85% (353.505), tahun 3 = 75% (311.916).
    // Tahun 4 dst belum ada datanya; kalau tenor > 36 dipakai faktor terakhir.
    'year_factors' => [
      1 => 1.00,
      2 => 0.85,
      3 => 0.75,
    ],

    // Dari Excel: ditambahkan ke total asuransi
    'extra_fee' => 25000,
  ],

  // Cicilan dibulatkan KE ATAS per 1.000 (cocok dengan 3 contoh Excel).
  // Pembulatan plafon di Excel dilakukan manual oleh leasing, jadi tidak ditiru.
  'round_installment' => 1000,
];
