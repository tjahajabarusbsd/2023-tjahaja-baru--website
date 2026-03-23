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
        $merchants = Merchant::where('aktif', true)->get();

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
            'qrcodes.promo' => function ($q) {
                $q->orderBy('start_date', 'asc');
            }
        ])->findOrFail($id);

        if (!$merchant) {
            return ApiResponse::error('Merchant tidak ditemukan', 404);
        }

        $merchantDetails = [
            'id' => $merchant->id,
            'name' => $merchant->title ?? '',
            'logo' => $merchant->image ? asset($merchant->image) : '',
            'info' => $merchant->deskripsi ?? '',
            'location' => $merchant->lokasi ?? '',
            'promos' => $merchant->qrcodes
                ->filter(fn($qrcode) => $qrcode->promo)
                ->map(function ($qrcode) {

                    $promo = $qrcode->promo;

                    if (!$promo->is_active) {
                        $status = 'nonaktif';
                    } elseif (now()->lt($promo->start_date)) {
                        $status = 'belum_aktif';
                    } elseif (now()->gt($promo->end_date)) {
                        $status = 'sudah_berakhir';
                    } else {
                        $status = 'aktif';
                    }

                    return [
                        'id' => $promo->id,
                        'title' => $promo->name ?? '',
                        'image' => $promo->image ? asset($promo->image) : '',
                        'uri' => $promo->uri ?? '',
                        'start_date' => $promo->start_date
                            ? $promo->start_date->format('d-m-Y')
                            : null,
                        'end_date' => $promo->end_date
                            ? $promo->end_date->format('d-m-Y')
                            : null,
                        'status' => $status
                    ];
                })
                ->values(),
        ];

        return ApiResponse::success('Detail merchant berhasil dimuat', $merchantDetails);
    }
}
