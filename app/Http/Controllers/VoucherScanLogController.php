<?php

namespace App\Http\Controllers;

use App\Models\RewardClaim;
use App\Models\VoucherScanLog;
use Illuminate\Http\Request;
use App\Helpers\ApiResponse;

class VoucherScanLogController extends Controller
{
    public function index(Request $request)
    {
        $merchantId = $request->user()->merchant_id;

        // Ambil query builder
        $query = VoucherScanLog::with(['rewardClaim.reward'])
            ->where('scanned_by_merchant_id', $merchantId);

        // === Filter bulan ===
        if ($request->has('month') && is_numeric($request->month)) {
            $query->whereMonth('scan_time', $request->month);
        }

        // === Filter tahun ===
        if ($request->has('year') && is_numeric($request->year)) {
            $query->whereYear('scan_time', $request->year);
        }

        // Urutkan terbaru
        $logs = $query->orderBy('scan_time', 'desc')->get();

        // Mapping data untuk frontend
        $data = $logs->map(function ($log) {
            return [
                'title' => $log->rewardClaim->reward->title ?? '-',

                'date_time' => $log->scan_time
                    ? $log->scan_time->format('d M Y H:i')
                    : null,

                'status' => match ($log->result_status) {
                    'valid' => 'Valid',
                    'expired' => 'Kadaluarsa',
                    default => 'Tidak Valid'
                }
            ];
        });

        return ApiResponse::success(
            'Riwayat scan berhasil diambil',
            $data
        );
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_voucher' => 'required',
        ]);

        $merchantUser = auth()->user();
        $merchant = $merchantUser->merchant;
        $kodeVoucher = $request->kode_voucher;

        $voucher = RewardClaim::with(['reward', 'userProfile'])
            ->where('kode_voucher', $kodeVoucher)
            ->first();

        /**
         * Helper untuk response konsisten
         */
        $responseData = function (?RewardClaim $voucher, bool $isValid, string $message) use ($merchant, $kodeVoucher) {
            return ApiResponse::success($message, [
                'voucher_name' => $voucher?->reward?->title ?? '-',
                'merchant_name' => $merchant?->title ?? '-',
                'expired_at' => $voucher?->expires_at
                    ? $voucher->expires_at->format('d F Y')
                    : '-',
                'voucher_code' => $kodeVoucher,
                'user_name' => $voucher?->userProfile?->userPublic->name ?? '-',
                'is_valid' => $isValid,
            ]);
        };

        /**
         * Case 1 — Voucher tidak ditemukan
         */
        if (!$voucher) {
            VoucherScanLog::create([
                'reward_claim_id' => null,
                'scanned_by_merchant_id' => $merchant->id,
                'result_status' => 'not_found',
                'scan_time' => now(),
            ]);

            return $responseData(null, false, 'Voucher tidak ditemukan');
        }

        /**
         * Case 2 — Voucher kadaluarsa
         */
        if (now()->gt($voucher->expires_at)) {
            VoucherScanLog::create([
                'reward_claim_id' => $voucher->id,
                'scanned_by_merchant_id' => $merchant->id,
                'result_status' => 'expired',
                'scan_time' => now(),
            ]);

            return $responseData($voucher, false, 'Voucher sudah kadaluarsa');
        }

        /**
         * Case 3 — Voucher sudah digunakan
         */
        if ($voucher->status === 'terpakai') {
            VoucherScanLog::create([
                'reward_claim_id' => $voucher->id,
                'scanned_by_merchant_id' => $merchant->id,
                'result_status' => 'used',
                'scan_time' => now(),
            ]);

            return $responseData($voucher, false, 'Voucher sudah digunakan');
        }

        /**
         * Case 4 — Voucher valid
         */
        $voucher->update([
            'status' => 'terpakai',
            'used_at' => now(),
        ]);

        VoucherScanLog::create([
            'reward_claim_id' => $voucher->id,
            'scanned_by_merchant_id' => $merchant->id,
            'result_status' => 'valid',
            'scan_time' => now(),
        ]);

        return $responseData($voucher, true, 'Voucher valid');
    }


}
