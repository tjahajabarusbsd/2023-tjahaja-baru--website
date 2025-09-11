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
        $merchants = Merchant::where('aktif', true)
            ->where('is_internal', false)
            ->whereHas('rewards', function ($query) {
                $query->where('aktif', true)
                    ->where('masa_berlaku_selesai', '>=', now());
            })
            ->with([
                'rewards' => function ($query) {
                    $query->where('aktif', true)
                        ->where('masa_berlaku_selesai', '>=', now());
                }
            ])
            ->get();

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

        return ApiResponse::success(
            $merchants->isNotEmpty()
            ? 'Daftar merchant berhasil diambil'
            : 'Tidak ada merchant tersedia',
            $formatted
        );
    }

    public function show($id): JsonResponse
    {
        $merchant = Merchant::with([
            'rewards' => function ($q) {
                $q->where('aktif', true)
                    ->where('masa_berlaku_selesai', '>=', now());
            }
        ])
            ->where('aktif', true)
            ->where('is_internal', false)
            ->whereHas('rewards', function ($q) {
                $q->where('aktif', true)
                    ->where('masa_berlaku_selesai', '>=', now());
            })
            ->find($id);

        if (!$merchant) {
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
                    'id' => $reward->id,
                    'title' => $reward->title,
                    'valid_until' => $reward->masa_berlaku_selesai->format('d-m-Y'),
                ];
            })->values(),
        ];

        return ApiResponse::success('Detail merchant berhasil dimuat', $merchantDetails);
    }
}
