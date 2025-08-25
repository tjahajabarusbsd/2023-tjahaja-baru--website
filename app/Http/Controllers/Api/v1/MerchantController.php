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

        if (!$merchants) {
            return ApiResponse::error('Tidak ada merchant tersedia', 404);
        }

        $formatted = $merchants->map(function ($merchant) {
            return [
                'id' => (string) $merchant->id,
                'name' => $merchant->title,
                'image' => $merchant->image
                    ? asset($merchant->image)
                    : 'https://example.com/img1.png',
                'isPromo' => (bool) $merchant->aktif,
            ];
        });

        return ApiResponse::success('Daftar merchant berhasil diambil', $formatted);
    }

    public function show($id): JsonResponse
    {
        // $merchant = Merchant::with(['rewards' => function ($q) {
        //     $q->where('aktif', true);
        // }])->where('aktif', true)->find($id);

        // if (!$merchant) {
        //     return ApiResponse::error('Merchant tidak ditemukan', 404);
        // }

        // Contoh data dummy detail merchant
        $merchantDetails = [
            '1' => [
                'id' => 1,
                'name' => 'Nama Merchant 1',
                'logo' => 'https://yourcdn.com/images/merchant1.png',
                'info' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam eu turpis molestie, dictum est a, mattis tellus.',
                'location' => [
                    [
                        'place' => 'Sentral Yamaha Damar',
                        'address' => 'Jl. Damar No. 59 (25117) Padang - Sumatera Barat INDONESIA'
                    ]
                ],
                'promos' => [
                    [
                        'title' => 'Promo Kredit Diskon',
                        'valid_until' => '25 Juli 2025'
                    ],
                    [
                        'title' => 'Diskon 20rb',
                        'valid_until' => '31 Des 2025'
                    ]
                ]
            ],
            // Kamu bisa tambah data lainnya di sini...
        ];

        if (!isset($merchantDetails[$id])) {
            return response()->json([
                'status' => 'error',
                'code' => 404,
                'message' => 'Merchant tidak ditemukan',
                'data' => null,
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'code' => 200,
            'message' => 'Detail merchant berhasil dimuat',
            'data' => $merchantDetails[$id],
        ], 200);
    }
}
