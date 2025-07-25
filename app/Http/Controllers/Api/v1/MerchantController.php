<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class MerchantController extends Controller
{
    public function index(): JsonResponse
    {
        $merchants = [
            [
                'id' => '1',
                'name' => 'Merchant Abc',
                'image' => 'https://example.com/img1.png',
                'isPromo' => false,
            ],
            [
                'id' => '2',
                'name' => 'Merchant Bde',
                'image' => 'https://example.com/img2.png',
                'isPromo' => false,
            ],
            [
                'id' => '3',
                'name' => 'Merchant Cfg',
                'image' => 'https://example.com/img3.png',
                'isPromo' => false,
            ],
            [
                'id' => '4',
                'name' => 'Merchant Dvb',
                'image' => 'https://example.com/img1.png',
                'isPromo' => false,
            ],
            [
                'id' => '5',
                'name' => 'Merchant Ezz',
                'image' => 'https://example.com/img2.png',
                'isPromo' => false,
            ],
            [
                'id' => '6',
                'name' => 'Merchant F',
                'image' => 'https://example.com/img3.png',
                'isPromo' => false,
            ],
        ];

        return response()->json([
            'status' => 'success',
            'code' => 200,
            'message' => 'Daftar merchant berhasil diambil',
            'data' => $merchants,
        ], 200);
    }

    public function show($id): JsonResponse
    {
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
