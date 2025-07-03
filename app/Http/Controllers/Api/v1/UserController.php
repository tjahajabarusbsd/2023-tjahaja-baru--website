<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function profile(Request $request)
    {
        return response()->json([
            'status' => "success",
            'code' => 200,
            'message' => 'Data user berhasil diambil',
            'data' => [
                'id' => (string) $request->user()->id,
                'name' => (string) $request->user()->name,
                'points' => 1200, // Contoh data poin
            ],
        ]);
    }
}
