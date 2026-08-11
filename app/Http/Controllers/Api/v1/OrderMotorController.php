<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\OrderMotor;
use App\Helpers\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

      $pesanan = OrderMotor::where('id', $orderId)
        ->where('user_public_id', $userPublicId)
        ->first();

      if (!$pesanan) {
        return ApiResponse::error('Pesanan tidak ditemukan', 404);
      }

      if ($pesanan->status !== 'pending') {
        return ApiResponse::error('Pesanan tidak bisa dibatalkan pada status ini', 400);
      }

      $pesanan->status = 'cancelled';
      $pesanan->save();

      return ApiResponse::success('Pesanan berhasil dibatalkan', $pesanan);
    } catch (\Throwable $e) {
      return ApiResponse::error('Gagal membatalkan pesanan: ' . $e->getMessage());
    }
  }
}
