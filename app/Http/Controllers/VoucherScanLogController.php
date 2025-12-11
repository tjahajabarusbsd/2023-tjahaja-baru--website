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

        return ApiResponse::success('Riwayat scan berhasil diambil', [
            'data' => $data
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_voucher' => 'required',
        ]);

        $merchant = auth()->user();
        $voucher = RewardClaim::where('kode_voucher', $request->kode_voucher)->first();

        // Case 1 — Voucher tidak ditemukan
        if (!$voucher) {
            VoucherScanLog::create([
                'reward_claim_id' => null,
                'scanned_by_merchant_id' => $merchant->merchant_id,
                'result_status' => 'not_found',
                'scan_time' => now(),
            ]);

            return ApiResponse::error('Voucher tidak ditemukan', 404);
        }

        // Case 2 — Voucher kadaluarsa
        if (now()->gt($voucher->expires_at)) {

            VoucherScanLog::create([
                'reward_claim_id' => $voucher->id,
                'scanned_by_merchant_id' => $merchant->merchant_id,
                'result_status' => 'expired',
                'scan_time' => now(),
            ]);

            return ApiResponse::error('Voucher sudah kadaluarsa', 400);
        }

        // Case 3 — Voucher sudah digunakan
        if ($voucher->status === 'terpakai') {

            VoucherScanLog::create([
                'reward_claim_id' => $voucher->id,
                'scanned_by_merchant_id' => $merchant->merchant_id,
                'result_status' => 'used',
                'scan_time' => now(),
            ]);

            return ApiResponse::error('Voucher sudah digunakan', 400);
        }

        // Case 4 — Voucher valid → tandai digunakan
        $voucher->update([
            'status' => 'terpakai',
            'used_at' => now(),
        ]);

        $log = VoucherScanLog::create([
            'reward_claim_id' => $voucher->id,
            'scanned_by_merchant_id' => $merchant->merchant_id,
            'result_status' => 'valid',
            'scan_time' => now(),
        ]);

        return ApiResponse::success('Voucher valid', [
            'kode_voucher' => $voucher->kode_voucher,
            'user_profile_id' => $voucher->user_profile_id,
            'reward_title' => $voucher->reward?->title,
            'status' => 'valid',
            'scan_log_id' => $log->id,
        ]);
    }

}
