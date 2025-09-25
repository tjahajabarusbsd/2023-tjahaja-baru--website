<?php

namespace App\Http\Controllers\Api\v1;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\QrScanRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QrScanController extends Controller
{
    public function store(QrScanRequest $request)
    {
        $user = Auth::user();
        $profile = $user->profile;

        $qrCode = $request->qr_code;
        if ($qrCode !== "QDFKADJIEKA") {
            return ApiResponse::error('QR code tidak valid.', null, 400);
        }

        $points = 100;

        $profile->total_points += $points;
        $profile->lifetime_points += $points;
        $profile->save();

        return ApiResponse::success('QR berhasil divalidasi. Poin telah ditambahkan.', [
            'points_received' => $points,
            'total_points' => $profile->total_points,
            'description' => 'Poin telah ditambahkan ke akunmu! Terus kumpulkan poin untuk mendapatkan hadiah menarik.'
        ]);
    }
}