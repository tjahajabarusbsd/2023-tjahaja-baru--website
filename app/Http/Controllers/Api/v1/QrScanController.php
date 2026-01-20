<?php

namespace App\Http\Controllers\Api\v1;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\QrScanRequest;
use App\Models\ActivityLog;
use App\Models\Qrcode;
use App\Models\RewardClaim;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class QrScanController extends Controller
{
    public function scan(QrScanRequest $request)
    {
        return $this->processQr($request, 'scan');
    }

    public function manualInput(QrScanRequest $request)
    {
        return $this->processQr($request, 'manual');
    }

    public function processQr(QrScanRequest $request, $type)
    {
        try {
            DB::beginTransaction();

            $user = Auth::user();
            // $profile = $user->profile;
            $qrCodeInput = $request->qr_code;

            // Cari QR code yang aktif menggunakan scope dari model
            $qrCode = Qrcode::aktif()->where('kode', $qrCodeInput)->first();

            if (!$qrCode) {
                return ApiResponse::error('QR code tidak valid', 404);
            }

            if (!$qrCode->masihBerlaku()) {
                return ApiResponse::error('QR code sudah tidak berlaku', 400);
            }

            if (!$qrCode->maxPenggunaan()) {
                return ApiResponse::error('Penggunaan sudah mencapai batas', 400);
            }

            $existingScan = ActivityLog::where('user_public_id', $user->id)
                ->where('source_type', Qrcode::class)
                ->where('source_id', $qrCode->id)
                ->exists();

            if ($existingScan) {
                return ApiResponse::error('Anda sudah menggunakan kode ini', 400);
            }

            // Ambil poin dari QR code
            // $points = $qrCode->poin;

            // Tambahkan poin ke user
            // $profile->total_points += $points;
            // $profile->lifetime_points += $points;
            // $profile->save();

            // Update jumlah penggunaan QR code
            $qrCode->increment('jumlah_penggunaan');

            // Tambahkan log aktivitas
            ActivityLog::create([
                'user_public_id' => $user->id,
                'source_type' => Qrcode::class,
                'source_id' => $qrCode->id,
                'type' => 'QR Scan',
                'title' => 'QR Code' . $qrCode->nama_qrcode,
                'description' => 'Berhasil melakukan scan QR Code: ' . $qrCode->nama_qrcode,
                'points' => 0,
                'activity_date' => now(),
                'metadata' => [
                    'scan_type' => $type,
                    'qr_code' => $qrCodeInput
                ]
            ]);

            DB::commit();

            return ApiResponse::success('QR berhasil divalidasi.', [
                'points_received' => 0,
                'total_points' => 0,
                'description' => 'Berhasil melakukan scan QR Code: ' . $qrCode->nama_qrcode
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return ApiResponse::error('Terjadi kesalahan saat memproses QR code: ' . $e->getMessage(), 500);
        }
    }
}