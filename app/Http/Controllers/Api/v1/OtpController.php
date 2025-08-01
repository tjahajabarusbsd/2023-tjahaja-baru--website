<?php

namespace App\Http\Controllers\Api\v1;

use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use App\Http\Requests\VerifyOtpRequest;
use App\Http\Requests\SendOtpRequest;
use App\Helpers\ApiResponse;
use App\Models\UserPublic;

class OtpController extends Controller
{
    public function verifyOtp(VerifyOtpRequest $request)
    {
        $user = UserPublic::where('phone_number', $request->phone_number)->first();

        if (!$user) {
            return ApiResponse::error('Nomor Handphone tidak ditemukan', 404);
        }

        if ($user->otp !== $request->otp) {
            return ApiResponse::error('Kode OTP salah', 401);
        }

        if ($user->otp_expires_at < Carbon::now()) {
            return ApiResponse::error('Kode OTP sudah kedaluwarsa', 401);
        }

        $user->update([
            'status_akun' => 'aktif',
            'otp' => null,
            'otp_expires_at' => null,
        ]);

        return ApiResponse::success('OTP berhasil diverifikasi', [
            'id' => (string) $user->id,
            'name' => (string) $user->name,
            'phone_number' => (string) $user->phone_number,
        ]);
    }

    public function sendOtp(SendOtpRequest $request)
    {
        $user = UserPublic::where('phone_number', $request->phone_number)->first();

        if (!$user) {
            return ApiResponse::error('Nomor Handphone belum terdaftar', 404);
        }

        if ($request->type === 'verifikasi' && $user->status_akun === 'aktif') {
            return ApiResponse::error('Akun sudah aktif. Tidak perlu verifikasi ulang.', 400);
        }

        if ($request->type === 'lupa_password' && $user->status_akun !== 'aktif') {
            return ApiResponse::error('Akun belum aktif. Tidak bisa reset password.', 400);
        }

        if ($user->otp_expires_at && $user->otp_expires_at > now()->subMinute()) {
            return ApiResponse::error('Kode OTP telah dikirim. Silakan tunggu sebentar.', 429);
        }

        $otp = rand(1000, 9999);
        $otpExpiresAt = Carbon::now()->addMinutes(5);

        $user->update([
            'otp' => $otp,
            'otp_expires_at' => $otpExpiresAt,
        ]);

        return ApiResponse::success('Kode OTP baru telah dikirim');
    }
}
