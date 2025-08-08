<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\ApiResponse;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function getUser(Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            return ApiResponse::error('Unauthorized', 401);
        }

        return ApiResponse::success('Data user berhasil diambil', [
            'id' => (string) $user->id,
            'name' => (string) $user->name,
            'points' => (int) ($user->profile->total_points ?? 0),
        ]);
    }

    public function getAccount(Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            return ApiResponse::error('Unauthorized', 401);
        }

        $points = (int) ($user->profile->total_points ?? 0);
        $membership = $this->getMembershipTier($points);

        return ApiResponse::success('Data akun berhasil dimuat', [
            'user_id'       => (int) $user->id,
            'name'          => (string) $user->name,
            'email'         => (string) $user->email,
            'no_handphone'  => (string) $user->phone_number,
            'jenis_kelamin' => $user->profile->jenis_kelamin ?? '',
            'tanggal_lahir' => $user->profile->tgl_lahir ?? '',
            'foto_profil'   => $user->profile->foto_profil ?? '',
            'membership'    => $membership,
        ]);
    }

    private function getMembershipTier(int $points): array
    {
        $tiers = [
            ['name' => 'Platinum', 'min_points' => 100000],
            ['name' => 'Gold',     'min_points' => 50000],
            ['name' => 'Silver',   'min_points' => 1000],
            ['name' => 'Basic',    'min_points' => 0],
        ];

        foreach ($tiers as $tier) {
            if ($points >= $tier['min_points']) {
                return [
                    'tier' => $tier['name'],
                    'points' => $points,
                ];
            }
        }

        return [
            'tier' => 'Unknown',
            'points' => $points,
        ];
    }
}
