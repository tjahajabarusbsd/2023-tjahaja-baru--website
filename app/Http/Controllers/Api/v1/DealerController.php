<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Dealer;
use Illuminate\Http\Request;

class DealerController extends Controller
{
    /**
     * Ambil semua dealer untuk dropdown.
     *
     * GET /api/v1/dealers                  -> semua dealer (menu daftar dealer)
     * GET /api/v1/dealers?feature=service  -> hanya dealer yang tersedia untuk booking servis
     */
    public function index(Request $request)
    {
        $query = Dealer::query();

        if ($request->query('feature') === 'service') {
            $query->where('is_booking_service_available', true);
        }

        // Ambil hanya id dan name untuk efisiensi
        $dealers = $query
            ->select('id', 'name_dealer as name')
            ->orderBy('name_dealer')
            ->get();

        return response()->json([
            'status' => 'success',
            'data' => $dealers
        ], 200);
    }
}
