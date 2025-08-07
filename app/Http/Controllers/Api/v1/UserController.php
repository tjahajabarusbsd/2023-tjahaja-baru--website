<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\ApiResponse;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function profile(Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            return ApiResponse::error('Unauthorized', 401);
        }

        return ApiResponse::success('Data user berhasil diambil', [
            'id' => (string) $user->id,
            'name' => (string) $user->name,
            'phone_number' => (string) $user->phone_number,
            'points' => (int) ($user->profile->total_points ?? 0),
            'tier' => (string) 'Basic', // Default tier, should be dynamic based on points
            'alamat' => (string) ($user->profile->alamat ?? ''),
            'tgl_lahir' => $user->profile->tgl_lahir ?? null,
            'jenis_kelamin' => $user->profile->jenis_kelamin ?? null,
            'foto_profil' => $user->profile->foto_profil ?? null,
        ]);
    }
}
