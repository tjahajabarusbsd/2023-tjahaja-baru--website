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
}
