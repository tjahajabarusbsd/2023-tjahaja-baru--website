<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LoyaltyTierController extends Controller
{
    public function index()
    {
        $response = [
            "status" => "success",
            "code" => 200,
            "message" => "Data loyalty tier berhasil diambil",
            "data" => [
                "current_points" => 1200,
                "current_tier" => [
                    "name" => "Silver",
                    "min_points" => 1000,
                    "max_points" => 49999,
                    "progress" => 0.2,
                    "color" => "#4D7CFE"
                ],
                "tiers" => [
                    [
                        "name" => "Basic",
                        "min_points" => 0,
                        "benefits" => [
                            "2 voucher servis",
                            "[Benefit lainnya]"
                        ]
                    ],
                    [
                        "name" => "Silver",
                        "min_points" => 1000,
                        "benefits" => [
                            "4 voucher servis",
                            "Diskon produk 5%"
                        ]
                    ],
                    [
                        "name" => "Gold",
                        "min_points" => 50000,
                        "benefits" => [
                            "6 voucher servis",
                            "Diskon produk 10%",
                            "Gratis ongkir"
                        ]
                    ],
                    [
                        "name" => "Platinum",
                        "min_points" => 100000,
                        "benefits" => [
                            "10 voucher servis",
                            "Diskon produk 15%",
                            "Gratis ongkir",
                            "Priority customer support"
                        ]
                    ]
                ]
            ]
        ];

        return response()->json($response, 200);
    }
}
