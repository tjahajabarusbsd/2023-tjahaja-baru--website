<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\OrderMotor;
use App\Helpers\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class OrderMotorController extends Controller
{
  public function index(Request $request)
  {
    try {
      $userPublicId = Auth::user()->id;

      $pesanan = OrderMotor::with('variant')
        ->where('user_public_id', $userPublicId)
        ->orderByDesc('created_at')
        ->get();

      return ApiResponse::success('Riwayat pemesanan berhasil diambil', $pesanan);
    } catch (\Throwable $e) {
      return ApiResponse::error('Gagal mengambil riwayat pemesanan: ' . $e->getMessage());
    }
  }

  public function show(Request $request, string $orderId)
  {
    try {
      $userPublicId = Auth::user()->id;

      $pesanan = OrderMotor::with('variant')
        ->where('id', $orderId)
        ->where('user_public_id', $userPublicId)
        ->first();

      if (!$pesanan) {
        return ApiResponse::error('Pesanan tidak ditemukan', 404);
      }

      return ApiResponse::success('Detail pesanan berhasil diambil', $pesanan);
    } catch (\Throwable $e) {
      return ApiResponse::error('Gagal mengambil detail pesanan: ' . $e->getMessage());
    }
  }

  public function cancel(Request $request, string $orderId)
  {
    try {
      $userPublicId = Auth::user()->id;

      $pesanan = DB::transaction(function () use ($orderId, $userPublicId) {
        $pesanan = OrderMotor::where('order_id', $orderId)
          ->where('user_public_id', $userPublicId)
          ->lockForUpdate()
          ->first();

        if (!$pesanan) {
          return null;
        }

        if ($pesanan->status !== 'pending') {
          Log::channel('order_motor')->warning('Percobaan cancel pesanan ditolak', [
            'order_id' => $orderId,
            'user_public_id' => $userPublicId,
            'status_saat_ini' => $pesanan->status,
          ]);
          return $pesanan;
        }

        $statusSebelum = $pesanan->status;
        $pesanan->status = 'cancelled';
        $pesanan->save();

        Log::channel('order_motor')->info('Pesanan dibatalkan user', [
          'order_id' => $orderId,
          'user_public_id' => $userPublicId,
          'status_sebelum' => $statusSebelum,
          'status_sesudah' => 'cancelled',
        ]);

        return $pesanan;
      });

      if (!$pesanan) {
        return ApiResponse::error('Pesanan tidak ditemukan', 404);
      }

      if ($pesanan->status !== 'cancelled') {
        return ApiResponse::error('Pesanan tidak bisa dibatalkan pada status ini', 400);
      }

      return ApiResponse::success('Pesanan berhasil dibatalkan', $pesanan);
    } catch (\Throwable $e) {
      Log::channel('order_motor')->error('Gagal membatalkan pesanan', [
        'order_id' => $orderId,
        'error' => $e->getMessage(),
      ]);
      return ApiResponse::error('Gagal membatalkan pesanan: ' . $e->getMessage());
    }
  }
}
