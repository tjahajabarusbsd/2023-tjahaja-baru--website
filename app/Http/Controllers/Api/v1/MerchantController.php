<?php

namespace App\Http\Controllers\Api\v1;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\Merchant;
use Illuminate\Http\JsonResponse;

class MerchantController extends Controller
{
    public function index(): JsonResponse
    {
        $merchants = Merchant::where('aktif', true)->where('is_internal', false)->get();

        if (!$merchants || $merchants->isEmpty()) {
            return ApiResponse::error('Tidak ada merchant tersedia', 404);
        }

        $formatted = $merchants->map(function ($merchant) {
            return [
                'id' => (string) $merchant->id,
                'name' => $merchant->title,
                'image' => $merchant->image
                    ? asset($merchant->image)
                    : '',
                'isPromo' => (bool) $merchant->aktif,
            ];
        });

        return ApiResponse::success('Daftar merchant berhasil diambil', $formatted);
    }

    public function show($id): JsonResponse
    {
        $merchant = Merchant::with([
            'rewards' => function ($q) {
                $q->where('aktif', true);
            }
        ])->where('aktif', true)->where('is_internal', false)->find($id);

        if (!$merchant || !$merchant->isEmpty()) {
            return ApiResponse::error('Merchant tidak ditemukan', 404);
        }

        $merchantDetails = [
            'id' => $merchant->id,
            'name' => $merchant->title ?? '',
            'logo' => $merchant->image
                ? asset($merchant->image)
                : '',
            'info' => $merchant->deskripsi ?? '',
            'location' => $merchant->lokasi ?? '',
            'promos' => $merchant->rewards->map(function ($reward) {
                return [
                    'title' => $reward->title,
                    'valid_until' => $reward->terms_conditions,
                ];
            }),
        ];

        return ApiResponse::success('Detail merchant berhasil dimuat', $merchantDetails);
    }
}
