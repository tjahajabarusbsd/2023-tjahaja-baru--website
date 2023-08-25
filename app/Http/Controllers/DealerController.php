<?php

namespace App\Http\Controllers;

use App\Models\Dealer;
use App\Models\Group;
use Illuminate\Http\Request;

class DealerController extends Controller
{
    public function getDealer(Request $request)
    {
        $perPage = 9; // Jumlah item per halaman
        $search = $request->input('search'); // Kata kunci pencarian
        $products = Group::inRandomOrder()->limit(3)->get();

        // Query builder untuk mencari dealer berdasarkan kolom 'name_dealer'
        $query = Dealer::query();
        if ($search) {
            $query->where('name_dealer', 'LIKE', '%' . $search . '%');
        }

        $dealers = $query->paginate($perPage);

        $dealers->appends(['search' => $search]); // Menambahkan kata kunci pencarian ke URL tautan halaman

        return view('dealers', compact('dealers', 'search', 'products'));
    }
}
