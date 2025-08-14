<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Dealer;

class DealerController extends Controller
{
    /**
     * Ambil semua dealer untuk dropdown.
     */
    public function index()
    {
        // Ambil hanya id dan name untuk efisiensi
        $dealers = Dealer::select('id', 'name_dealer as name')->get();

        return response()->json([
            'status' => 'success',
            'data' => $dealers
        ], 200);
    }
}
