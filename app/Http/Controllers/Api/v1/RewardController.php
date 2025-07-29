<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RewardController extends Controller
{
    public function index()
    {
        $rewards = [
            [
                "id" => (string) 1,
                "title" => "voucher diskon 10%",
                "points_required" => 1000,
                "image_url" => "https://via.placeholder.com/150",
                "detail" => "Get 10% off on your next purchase",
            ],
            [
                "id" => (string) 2,
                "title" => "voucher diskon 25%",
                "points_required" => 2500,
                "image_url" => "https://via.placeholder.com/150",
                "detail" => "Save 25% on selected items",
            ],
            [
                "id" => (string) 3,
                "title" => "voucher diskon 10%",
                "points_required" => 1000,
                "image_url" => "https://via.placeholder.com/150",
                "detail" => "Applicable on all products",
            ],
            [
                "id" => (string) 4,
                "title" => "voucher diskon 25%",
                "points_required" => 2500,
                "image_url" => "https://via.placeholder.com/150",
                "detail" => "Limited time offer",
            ],
        ];

        return response()->json([
            "status" => "success",
            "code" => 200,
            "message" => "Data voucher berhasil diambil",
            "data" => $rewards
        ]);
    }

    public function show($id)
    {
        $rewardDetails = [
            '1' => [
                'id' => (string) 1,
                'title' => 'voucher diskon 25%',
                "points_required" => 2500,
                'image_url' => 'https://via.placeholder.com/300x150',
                'description' => "Dapatkan voucher diskon 25% untuk pembelian di merchant A.",
                'terms_conditions' => "Voucher ini berlaku untuk pembelian minimal Rp 100.000. Tidak dapat digabung dengan promo lain.",
                'is_redeemable' => true,
            ],
        ];

        if (!isset($rewardDetails[$id])) {
            return response()->json([
                'status' => 'error',
                'code' => 404,
                'message' => 'Detail reward tidak ditemukan',
                'data' => null,
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'code' => 200,
            'message' => 'Detail reward berhasil diambil',
            'data' => $rewardDetails[$id],
        ], 200);
    }
}
