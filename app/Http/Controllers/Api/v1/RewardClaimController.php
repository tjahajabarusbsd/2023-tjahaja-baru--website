<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Helpers\ApiResponse;
use App\Models\RewardClaim;

class RewardClaimController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $userProfile = $user->profile;

        $claims = RewardClaim::with('reward.merchant')
            ->where('user_profile_id', $userProfile->id)
            ->latest()
            ->get();

        $formatted = $claims->map(function ($claim) {
            return [
                'id' => (string) $claim->id,
                'merchantName' => $claim->reward->merchant ? $claim->reward->merchant->title : null,
                'promo' => $claim->reward->title,
                'status' => $claim->status_label,
                'expiredAt' => $claim->expires_at,
                'logoUrl' => $claim->reward->merchant && $claim->reward->merchant->image
                    ? asset($claim->reward->merchant->image)
                    : null,
            ];
        });

        return ApiResponse::success('Daftar reward yang sudah diklaim', $formatted);
    }

    public function show($id)
    {
        $user = auth()->user();
        $userProfile = $user->profile;

        $claim = RewardClaim::with('reward.merchant')
            ->where('user_profile_id', $userProfile->id)
            ->where('id', $id)
            ->first();

        if (!$claim) {
            return ApiResponse::error('Detail hadiah tidak ditemukan', 404);
        }

        $data = [
            'id' => (string) $claim->id,
            'merchantName' => $claim->reward->merchant ? $claim->reward->merchant->title : null,
            'promo' => $claim->reward->title,
            'qrCode' => $claim->kode_voucher,
            'instruction' => 'Lihatkan Kode QR ini ke kasir'
        ];

        return ApiResponse::success('Detail reward claim berhasil diambil', $data);
    }
}