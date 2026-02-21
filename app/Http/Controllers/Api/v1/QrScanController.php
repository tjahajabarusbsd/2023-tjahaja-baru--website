<?php

namespace App\Http\Controllers\Api\v1;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\QrScanRequest;
use App\Models\ActivityLog;
use App\Models\Notification;
use App\Models\Qrcode;
use App\Models\QrScanLog;
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

            $alreadyScanned = QrScanLog::where('user_public_id', $user->id)
                ->where('qrcode_id', $qrCode->id)
                ->exists();

            if ($alreadyScanned) {
                throw new \Exception('Anda sudah menggunakan kode ini', 400);
            }

            $nextUsage = $qrCode->jumlah_penggunaan + 1;
            $scanCode = 'TRX-' . strtoupper(uniqid());

            $qrCode->increment('jumlah_penggunaan');

            $qrScanLog = QrScanLog::create([
                'scan_code' => $scanCode,
                'user_public_id' => $user->id,
                'qrcode_id' => $qrCode->id,
                'usage_count' => $nextUsage,
                'max_usage' => $qrCode->max_penggunaan,
                'scanned_at' => now(),
            ]);

            ActivityLog::create([
                'user_public_id' => $user->id,
                'source_type' => QrScanLog::class,
                'source_id' => $qrScanLog->id,
                'type' => 'QR_SCAN',
                'title' => 'Scan QR ' . $qrCode->nama_qrcode,
                'description' => 'Scan berhasil',
                'points' => 0,
                'activity_date' => now(),
            ]);

            Notification::create([
                'user_public_id' => $user->id,
                'source_type' => QrScanLog::class,
                'source_id' => $qrScanLog->id,
                'category' => 'QR Scan',
                'title' => 'Scan QR Berhasil',
                'description' => 'Promo ' . $qrCode->nama_qrcode . ' di ' . $qrCode->merchant->title . ' berhasil digunakan.',
                'is_read' => false,
            ]);

            DB::commit();

            return ApiResponse::success('QR berhasil divalidasi.', [
                'scan_id' => $qrScanLog->scan_code,
                'nama_qrcode' => $qrCode->nama_qrcode,
                'merchant_name' => $qrCode->merchant->title,
                'user_name' => $user->name,
                'usage_count' => $nextUsage,
                'max_usage' => $qrCode->max_penggunaan,
                'waktu_scan' => $qrScanLog->scanned_at->format('d/m/Y H:i'),
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