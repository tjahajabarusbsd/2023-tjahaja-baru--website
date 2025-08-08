<?php

namespace App\Http\Controllers\Api\v1;

use App\Helpers\ApiResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ActivityController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if (!$user) {
            return ApiResponse::error('Unauthorized', 401);
        }

        $activity = [
            [
                "id" => 1,
                "type" => "redeem",
                "title" => "Redeem",
                "description" => "25% discount voucher",
                "date" => "Today, 1 Dec 2025",
                "points" => "-2500"
            ],
            [
                "id" => 2,
                "type" => "services",
                "title" => "Servis telah dipesan",
                "description" => "",
                "date" => "28 November 2025",
                "points" => ""
            ],
            [
                "id" => 3,
                "type" => "referral",
                "title" => "Invite Friends",
                "description" => "Referral code",
                "date" => "Today, 1 Dec 2025",
                "points" => "+500"
            ],
            [
                "id" => 4,
                "type" => "scan",
                "title" => "Scan QR Code",
                "description" => "QR code touring",
                "date" => "Today, 1 Dec 2025",
                "points" => "+500"
            ]
        ];

        return response()->json([
            "status" => "success",
            "code" => 200,
            "message" => "Riwayat aktivitas poin berhasil dimuat",
            "data" => $activity
        ]);
    }
}
