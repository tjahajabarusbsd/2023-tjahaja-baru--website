<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Promo;
use Carbon\Carbon;

class PromoController extends Controller
{
  public function detail($uri)
  {
    $promo = Promo::where('uri', $uri)
      ->where('is_active', true)
      ->where('show_on_mobile', true)
      ->firstOrFail();

    return view('promo.detail', compact('promo'));
  }
}
