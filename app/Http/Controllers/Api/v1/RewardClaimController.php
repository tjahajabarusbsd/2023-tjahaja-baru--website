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
                'logoUrl' => '',
            ];
        });

        return ApiResponse::success('Daftar reward yang sudah diklaim', $formatted);
    }
}