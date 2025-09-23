<?php

namespace App\Http\Controllers\Api\v1;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\Reward;
use App\Models\RewardClaim;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class RewardController extends Controller
{
    public function index(): JsonResponse
    {
        $rewards = Reward::with('merchant')
            ->where('aktif', true)
            ->where('masa_berlaku_selesai', '>=', now())
            ->where('type', 'public')
            ->whereHas('merchant', function ($q) {
                $q->where('aktif', true);
            })
            ->get();

        if ($rewards->isEmpty()) {
            return ApiResponse::error('Tidak ada reward tersedia', 404);
        }

        $formatted = $rewards->map(function ($reward) {
            return [
                'id' => (string) $reward->id,
                'title' => $reward->title,
                'image_url' => $reward->image
                    ? asset($reward->image)
                    : 'https://placehold.co/150.png',
                'points_required' => (int) $reward->point,
                'detail' => $reward->deskripsi,
            ];
        });

        return ApiResponse::success('List reward berhasil diambil', $formatted);
    }

    public function show(int $id): JsonResponse
    {
        $reward = Reward::with('merchant')
            ->where('aktif', true)
            ->where('id', $id)
            ->where('masa_berlaku_selesai', '>=', now())
            ->whereHas('merchant', function ($q) {
                $q->where('aktif', true);
            })
            ->first();

        if (!$reward) {
            return ApiResponse::error('Reward tidak ditemukan', 404);
        }

        $rewardDetails = [
            'id' => (string) $reward->id,
            'title' => $reward->title,
            'points_required' => (int) $reward->point,
            'image_url' => $reward->image
                ? asset($reward->image)
                : 'https://placehold.co/150.png',
            'description' => $reward->deskripsi,
            'terms_conditions' => $reward->terms_conditions,
            'is_redeemable' => true,
        ];

        return ApiResponse::success('Detail reward berhasil diambil', $rewardDetails);
    }

    public function store(Request $request, $id)
    {
        // $request->validate([
        //     'shipping_address' => 'nullable|string',
        // ]);

        $reward = Reward::find($id);
        $user = auth()->user();
        $userProfile = $user->profile;

        if (!$reward) {
            return ApiResponse::error('Reward tidak ditemukan', 404);
        }
        if (!$userProfile) {
            return ApiResponse::error('User profile tidak ditemukan', 404);
        }
        if (!$reward->aktif) {
            return ApiResponse::error('Reward tidak aktif', 400);
        }
        if ($reward->masa_berlaku_mulai && now()->lt($reward->masa_berlaku_mulai)) {
            return ApiResponse::error('Reward belum tersedia', 400);
        }
        if ($reward->masa_berlaku_selesai && now()->gt($reward->masa_berlaku_selesai)) {
            return ApiResponse::error('Reward sudah tidak berlaku', 400);
        }
        if ($reward->quantity <= 0) {
            return ApiResponse::error('Stok reward habis', 400);
        }
        if ($userProfile->total_points < $reward->point) {
            return ApiResponse::error('Poin tidak cukup', 400);
        }

        DB::beginTransaction();
        try {
            $userProfile->decrement('total_points', $reward->point);
            $reward->decrement('quantity');

            $claim = RewardClaim::create([
                'user_profile_id' => $userProfile->id,
                'reward_id' => $reward->id,
                'status' => 'aktif',
                'point_used' => $reward->point,
                'kode_voucher' => $reward->type === 'voucher' ? strtoupper(Str::random(10)) : null,
                'shipping_address' => $request->shipping_address,
                'source' => 'manual',
                'expires_at' => $reward->type === 'voucher' ? now()->addDays(7) : null,
            ]);

            DB::commit();

            return ApiResponse::success('Reward berhasil diklaim', [
                'id' => (string) $reward->id,
                'title' => (string) $reward->title,
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return ApiResponse::error('Gagal klaim reward: ' . $e->getMessage(), 500);
        }
    }
}
