<?php

namespace App\Services;

use App\Models\Reward;
use App\Models\RewardClaim;
use Illuminate\Support\Str;

class LoyaltyService
{
    public static function getTierByPoints(int $lifetimePoints): array
    {
        $tiers = config('loyalty.tiers');
        $currentTier = $tiers[0];

        foreach (array_reverse($tiers) as $tier) {
            if ($lifetimePoints >= $tier['min_points']) {
                $currentTier = $tier;
                break;
            }
        }

        return [
            'tier' => $currentTier['name'],
            'points' => $lifetimePoints,
            'color' => $currentTier['color'],
            'voucher_service' => $currentTier['voucher_service'],
        ];
    }

    public static function grantTierBenefits($userProfile, string $tierName): void
    {
        $tiers = config('loyalty.tiers');
        $tier = collect($tiers)->firstWhere('name', $tierName);

        if (!$tier) {
            return;
        }

        $reward = Reward::where('type', 'loyalty')->first();
        if (!$reward) {
            return;
        }

        for ($i = 0; $i < $tier['voucher_service']; $i++) {
            RewardClaim::create([
                'user_profile_id' => $userProfile->id,
                'reward_id' => $reward->id,
                'status' => 'aktif',
                'point_used' => 0,
                'kode_voucher' => Str::upper(Str::random(10)),
                'source' => 'loyalty_' . strtolower($tierName),
                'expires_at' => now()->addMonths(6),
            ]);
        }
    }
}
