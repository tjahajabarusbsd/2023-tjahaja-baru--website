<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoyaltyTierController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $points = (int) ($user->profile->lifetime_points ?? 0);

        $tiers = config('loyalty.tiers');
        $currentTier = $tiers[0];

        foreach (array_reverse($tiers) as $tier) {
            if ($points >= $tier['min_points']) {
                $currentTier = $tier;
                break;
            }
        }

        // Hitung progress
        if (isset($currentTier['max_points']) && $currentTier['max_points'] !== null) {
            $progress = ($points - $currentTier['min_points']) /
                ($currentTier['max_points'] - $currentTier['min_points']);
            $progress = max(0, min(1, round($progress, 2)));
        } else {
            $progress = 1;
        }

        // Generate benefits dummy
        $generateBenefits = function ($tier) {
            return [
                $tier['voucher_service'] . ' voucher servis'
            ];
        };

        $response = [
            "status" => "success",
            "code" => 200,
            "message" => "Data loyalty tier berhasil diambil",
            "data" => [
                "current_points" => $points,
                "current_tier" => [
                    "name" => $currentTier['name'],
                    "min_points" => $currentTier['min_points'],
                    "max_points" => $currentTier['max_points'] ?? null,
                    "progress" => $progress,
                    "color" => $currentTier['color'],
                    "benefits" => $generateBenefits($currentTier),
                ],
                "tiers" => array_map(function ($tier) use ($generateBenefits) {
                    return [
                        "name" => $tier['name'],
                        "min_points" => $tier['min_points'],
                        "max_points" => $tier['max_points'] ?? null,
                        "color" => $tier['color'],
                        "benefits" => $generateBenefits($tier),
                    ];
                }, $tiers)
            ]
        ];

        return response()->json($response, 200);
    }
}
