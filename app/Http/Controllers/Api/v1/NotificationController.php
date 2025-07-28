<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = [
            [
                "id" => 1,
                "type" => "pembelian_motor",
                "title" => "Pembelian Motor Berhasil",
                "message" => "Pembelian motor Yamaha Aerox Anda telah berhasil dan sedang diproses.",
                "time" => "2025-07-28T10:30:00Z",
                "relative_time" => "5 menit lalu",
                "isRead" => false,
                "related_id" => 1234
            ],
            [
                "id" => 2,
                "type" => "jadwal_servis",
                "title" => "Pengingat Jadwal Servis",
                "message" => "Motor Anda dijadwalkan servis pada 30 Juli 2025 pukul 10:00.",
                "time" => "2025-07-27T09:00:00Z",
                "relative_time" => "5 menit lalu",
                "isRead" => false,
                "related_id" => 5678
            ],
            [
                "id" => 3,
                "type" => "promo",
                "title" => "Promo Servis Spesial",
                "message" => "Dapatkan diskon 20% untuk servis motor bulan ini.",
                "time" => "2025-07-25T08:15:00Z",
                "relative_time" => "5 menit lalu",
                "isRead" => true,
                "related_id" => null
            ]
        ];

        return response()->json([
            "status" => "success",
            "code" => 200,
            "message" => "Daftar notifikasi berhasil dimuat",
            "data" => $notifications
        ]);
    }
}
