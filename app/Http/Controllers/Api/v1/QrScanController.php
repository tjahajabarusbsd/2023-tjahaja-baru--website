<?php

namespace App\Http\Controllers\Api\v1;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\QrScanRequest;
use App\Models\ActivityLog;
use App\Models\Notification;
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
        DB::beginTransaction();

        try {
            $user = Auth::user();
            $qrCodeInput = $request->qr_code;

            $qrCode = Qrcode::aktif()
                ->where('kode', $qrCodeInput)
                ->lockForUpdate()
                ->first();

            if (!$qrCode) {
                throw new \Exception('QR code tidak valid', 404);
            }

            if (!$qrCode->masihBerlaku()) {
                throw new \Exception('QR code sudah tidak berlaku', 400);
            }

            if (!$qrCode->maxPenggunaan()) {
                throw new \Exception('Penggunaan sudah mencapai batas', 400);
            }

            $alreadyScanned = ActivityLog::where('user_public_id', $user->id)
                ->where('source_type', Qrcode::class)
                ->where('source_id', $qrCode->id)
                ->exists();

            if ($alreadyScanned) {
                throw new \Exception('Anda sudah menggunakan kode ini', 400);
            }

            $qrCode->increment('jumlah_penggunaan');

            ActivityLog::create([
                'user_public_id' => $user->id,
                'source_type' => Qrcode::class,
                'source_id' => $qrCode->id,
                'type' => 'QR_SCAN',
                'title' => 'Scan QR ' . $qrCode->nama_qrcode,
                'description' => 'Scan berhasil',
                'points' => 0,
                'activity_date' => now(),
            ]);

            Notification::create([
                'user_public_id' => $user->id,
                'source_type' => Qrcode::class,
                'source_id' => $qrCode->id,
                'title' => 'Scan QR Berhasil',
                'description' => $qrCode->nama_qrcode,
                'is_read' => false,
            ]);

            DB::commit();

            return ApiResponse::success('QR berhasil divalidasi.', [
                'qr_code_id' => $qrCode->id,
                'nama_qrcode' => $qrCode->nama_qrcode,
                'merchant_id' => $qrCode->merchant_id,
                'merchant_name' => $qrCode->merchant->name,
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return ApiResponse::error(
                $e->getMessage() ?: 'Terjadi kesalahan',
                $e->getCode() ?: 500
            );
        }
    }
}