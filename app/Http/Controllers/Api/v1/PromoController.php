<?php

namespace App\Http\Controllers\Api\v1;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\Promo;

class PromoController extends Controller
{
  public function index()
  {
    $promos = Promo::where('is_active', true)
      ->where('show_on_mobile', true)
      ->orderBy('id', 'desc')
      ->get();

    $formattedPromos = $promos->map(function ($promo) {
      return [
        'id' => (string) $promo->id,
        'name' => $promo->name,
        'image' => $promo->image ? asset($promo->image) : null,
        'uri' => $promo->uri,
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