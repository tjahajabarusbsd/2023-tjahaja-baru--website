<?php

namespace App\Http\Controllers\Api\v1;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\QrScanRequest;
use App\Models\Notification;
use App\Models\Qrcode;
use App\Models\QrScanLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Exception;

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

    private function getValidQr($kode)
    {
        $qrCode = Qrcode::aktif()
            ->where('kode', $kode)
            ->lockForUpdate()
            ->first();

        if (!$qrCode)
            throw new Exception('QR code tidak valid', 404);
        if (!$qrCode->masihBerlaku())
            throw new Exception('QR tidak aktif', 400);
        if (!$qrCode->jamAktif())
            throw new Exception('QR tidak aktif di jam ini', 400);
        if (!$qrCode->hariAktif())
            throw new Exception('QR tidak aktif hari ini', 400);

        return $qrCode;
    }

    private function validateLimit($qrCode, $user)
    {
        // cek max penggunaan global
        if (!$qrCode->maxPenggunaan()) {
            throw new Exception('Penggunaan sudah mencapai batas', 400);
        }

        // cek apakah user sudah pernah scan
        $alreadyScanned = QrScanLog::where('user_public_id', $user->id)
            ->where('qrcode_id', $qrCode->id)
            ->exists();

        if ($alreadyScanned) {
            throw new Exception('Anda sudah menggunakan kode ini', 400);
        }
    }

    private function validateKategori($qrCode, $user)
    {
        if (!$qrCode->category_id) {
            return; // tidak ada pembatasan kategori
        }

        $userModel = optional($user->nomorRangkas->first())->nama_model;

        if (!$userModel) {
            throw new Exception('Data motor tidak ditemukan', 400);
        }

        $matchedCategory = \App\Models\Category::matchCategoryByModelName($userModel);

        if (!$matchedCategory || $matchedCategory->id != $qrCode->category_id) {
            throw new Exception('QR ini tidak berlaku untuk tipe motor Anda', 403);
        }
    }

    private function handleLink($qrCode, $user)
    {
        if (!$qrCode->redirect_url) {
            throw new Exception('Redirect URL tidak ditemukan', 500);
        }

        DB::commit();

        return ApiResponse::success('QR redirect.', [
            'type' => 'link',
            'redirect_url' => $qrCode->redirect_url,
            'nama_qrcode' => $qrCode->nama_qrcode,
            'merchant_name' => $qrCode->promo->merchant->title,

            'scan_id' => null,
            'user_name' => null,
            'usage_count' => null,
            'max_usage' => null,
            'waktu_scan' => null,
        ]);
    }

    private function handleKode($qrCode, $user)
    {
        $this->validateKategori($qrCode, $user);
        $this->validateLimit($qrCode, $user);

        $nextUsage = $qrCode->jumlah_penggunaan + 1;
        $scanCode = 'TRX-' . strtoupper(uniqid());

        $qrCode->increment('jumlah_penggunaan');

        $log = QrScanLog::create([
            'scan_code' => $scanCode,
            'user_public_id' => $user->id,
            'qrcode_id' => $qrCode->id,
            'usage_count' => $nextUsage,
            'max_usage' => $qrCode->max_penggunaan,
            'scanned_at' => now(),
        ]);

        Notification::create([
            'user_public_id' => $user->id,
            'source_type' => QrScanLog::class,
            'source_id' => $log->id,
            'category' => 'QR Scan',
            'title' => 'Scan QR Berhasil',
            'description' => 'Promo ' . $qrCode->nama_qrcode . ' di ' . $qrCode->promo->merchant->title . ' berhasil digunakan.',
            'is_read' => false,
        ]);

        DB::commit();

        return ApiResponse::success('QR berhasil divalidasi.', [
            'type' => 'kode',
            'redirect_url' => null,
            'scan_id' => $scanCode,
            'nama_qrcode' => $qrCode->nama_qrcode,
            'merchant_name' => $qrCode->promo->merchant->title,
            'user_name' => $user->name,
            'usage_count' => $nextUsage,
            'max_usage' => $qrCode->max_penggunaan,
            'waktu_scan' => $log->scanned_at->format('d/m/Y H:i'),
        ]);
    }

    public function processQr(QrScanRequest $request, $type)
    {
        DB::beginTransaction();

        try {
            $user = Auth::user();
            $qrCode = $this->getValidQr($request->qr_code);

            if ($qrCode->tipe_qr === Qrcode::TIPE_LINK) {
                return $this->handleLink($qrCode, $user);
            }

            return $this->handleKode($qrCode, $user);

        } catch (Exception $e) {
            DB::rollBack();
            return ApiResponse::error(
                $e->getMessage() ?: 'Terjadi kesalahan',
                $e->getCode() ?: 500
            );
        }
    }
}