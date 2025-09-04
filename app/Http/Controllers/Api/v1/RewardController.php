<?php

namespace App\Http\Controllers\Api\v1;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\Reward;
use Illuminate\Http\JsonResponse;

class RewardController extends Controller
{
    public function index(): JsonResponse
    {
        $rewards = Reward::with('merchant')
            ->where('aktif', true)
            ->where('masa_berlaku_selesai', '>=', now())
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
}
