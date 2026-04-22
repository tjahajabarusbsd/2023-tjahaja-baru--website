<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class OnboardingController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json([
            "status" => "success",
            "code" => 200,
            "message" => "Permintaan berhasil diproses",
            "data" => [
                [
                    "id" => 1,
                    "title" => "Kelola Kebutuhan Motor dalam Satu Aplikasi"
                ],
                [
                    "id" => 2,
                    "title" => "Booking Servis Tanpa Perlu Antre"
                ],
                [
                    "id" => 3,
                    "title" => "Pantau Riwayat Servis dengan Mudah"
                ],
                [
                    "id" => 4,
                    "title" => "Scan QR & Nikmati Promo Merchant"
                ]
            ]
        ]);
    }
}
