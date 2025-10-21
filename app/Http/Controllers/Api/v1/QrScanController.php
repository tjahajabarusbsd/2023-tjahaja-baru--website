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
            $profile = $user->profile;
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
            $points = $qrCode->poin;

            // Tambahkan poin ke user
            $profile->total_points += $points;
            $profile->lifetime_points += $points;
            $profile->save();

            // Update jumlah penggunaan QR code
            $qrCode->increment('jumlah_penggunaan');

            // Tambahkan log aktivitas
            ActivityLog::create([
                'user_public_id' => $user->id,
                'source_type' => Qrcode::class,
                'source_id' => $qrCode->id,
                'type' => 'QR Scan',
                'title' => 'Poin dari QR Code',
                'description' => 'Berhasil mendapatkan poin dari QR Code: ' . $qrCode->nama_qrcode,
                'points' => $points,
                'activity_date' => now(),
                'metadata' => [
                    'scan_type' => $type,
                    'qr_code' => $qrCodeInput
                ]
            ]);

            DB::commit();

            return ApiResponse::success('QR berhasil divalidasi. Poin telah ditambahkan.', [
                'points_received' => (int) $points,
                'total_points' => (int) $profile->total_points,
                'description' => 'Poin telah ditambahkan ke akunmu! Terus kumpulkan poin untuk mendapatkan hadiah menarik.'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return ApiResponse::error('Terjadi kesalahan saat memproses QR code: ' . $e->getMessage(), 500);
        }
    }

    public function scanByKasir(Request $request)
    {
        $voucher = RewardClaim::where('kode_voucher', $request->kode_voucher)->first();

        if (!$voucher) {
            return ApiResponse::error('Voucher tidak ditemukan', 404);
        }

        if ($voucher->status !== 'aktif') {
            return ApiResponse::error('Voucher sudah digunakan atau tidak aktif', 400);
        }

        if (now()->gt($voucher->expires_at)) {
            return ApiResponse::error('Voucher sudah kadaluarsa', 400);
        }

        $voucher->update([
            'status' => 'terpakai',
            'updated_at' => now(),
        ]);

        return ApiResponse::success('Voucher valid', [
            'kode_voucher' => $voucher->kode_voucher,
            'user_profile_id' => $voucher->user_profile_id,
            'reward_title' => $voucher->reward ? $voucher->reward->title : null,
            'status' => $voucher->status,
        ]);

    }
}