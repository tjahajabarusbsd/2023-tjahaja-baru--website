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
                    "title" => "Gabung dan Nikmati Berbagai Keuntungan"
                ],
                [
                    "id" => 2,
                    "title" => "Dapatkan Reward dari Setiap Aktivitas"
                ],
                [
                    "id" => 3,
                    "title" => "Tukarkan Reward dengan Hadiah Menarik"
                ],
                [
                    "id" => 4,
                    "title" => "Semakin Aktif, Semakin Banyak Manfaat"
                ]
            ]
        ]);
    }
}
