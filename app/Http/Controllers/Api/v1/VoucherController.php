<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class VoucherController extends Controller
{
    public function index()
    {
        $voucher = [
            [
                "id" => (string) 1,
                "merchantName" => "Merchant A",
                "promo" => "Diskon Rp 20.000",
                "status" => "aktif",
                "expiredAt" => "2025-06-30",
                "logoUrl" => "https://via.placeholder.com/60x60.png?text=Logo",
            ],
            [
                "id" => (string) 2,
                "merchantName" => "Merchant B",
                "promo" => "Buy 1 get 1",
                "status" => "aktif",
                "expiredAt" => "2025-07-15",
                "logoUrl" => "https://via.placeholder.com/60x60.png?text=Logo",
            ],
            [
                "id" => (string) 3,
                "merchantName" => "Merchant C",
                "promo" => "Diskon 10%",
                "status" => "terpakai",
                "expiredAt" => "2025-07-15",
                "logoUrl" => "https://via.placeholder.com/60x60.png?text=Logo",
            ],
            [
                "id" => (string) 4,
                "merchantName" => "Merchant D",
                "promo" => "Gratis Minuman",
                "status" => "kadaluarsa",
                "expiredAt" => "2025-07-15",
                "logoUrl" => "https://via.placeholder.com/60x60.png?text=Logo",
            ],
        ];

        return response()->json([
            "status" => "success",
            "code" => 200,
            "message" => "Data voucher berhasil diambil",
            "data" => $voucher
        ]);
    }

    public function show($id)
    {
        $voucherDetails = [
            '1' => [
                'id' => (string) 1,
                'merchantName' => 'Merchant A',
                'promo' => 'Diskon Rp 20.000',
                'qrCode' => "https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=VOUCHER-123456",
                'instruction' => "Lihatkan Kode QR ini ke kasir",
            ],
        ];

        if (!isset($voucherDetails[$id])) {
            return response()->json([
                'status' => 'error',
                'code' => 404,
                'message' => 'Voucher tidak ditemukan',
                'data' => null,
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'code' => 200,
            'message' => 'Detail voucher berhasil diambil',
            'data' => $voucherDetails[$id],
        ], 200);
    }
}
