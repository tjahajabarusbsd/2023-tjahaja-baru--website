<?php

namespace App\Http\Controllers\Api\v1;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\Promo;

class PromoController extends Controller
{
  public function index()
  {
    $promos = Promo::where('show_on_mobile', true)
      ->orderBy('created_at', 'desc')
      ->where('is_active', true)
      ->get();

    $formattedPromos = $promos->map(function ($promo) {
      if (now()->lt($promo->start_date)) {
        $status = 'belum_aktif';
      } elseif (now()->gt($promo->end_date->endOfDay())) {
        $status = 'sudah_berakhir';
      } else {
        $status = 'aktif';
      }

      return [
        'id' => (string) $promo->id,
        'name' => $promo->name,
        'image' => $promo->image ? asset($promo->image) : null,
        'uri' => $promo->uri,
        'start_date' => $promo->start_date
          ? $promo->start_date->format('d-m-Y')
          : null,
        'end_date' => $promo->end_date
          ? $promo->end_date->format('d-m-Y')
          : null,
        'status' => $status,
      ];
    });

    return ApiResponse::success(
      $promos->isNotEmpty()
      ? 'Daftar promo berhasil diambil'
      : 'Tidak ada promo tersedia',
      $formattedPromos
    );
  }
}