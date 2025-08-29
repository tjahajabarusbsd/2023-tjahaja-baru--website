<?php

namespace App\Http\Controllers\Api\v1;

use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use App\Http\Requests\VerifyOtpRequest;
use App\Http\Requests\SendOtpRequest;
use App\Helpers\ApiResponse;
use App\Models\UserPublic;
use Illuminate\Support\Facades\DB;

class OtpController extends Controller
{
    public function verifyOtp(VerifyOtpRequest $request)
    {
        $user = UserPublic::where('phone_number', $request->phone_number)->first();

        if (!$user) {
            return ApiResponse::error('Nomor Handphone tidak ditemukan', 404);
        }

        if ($user->otp !== $request->otp) {
            return ApiResponse::error('Kode OTP salah', 401, [
                'id' => (string) $user->id,
                'name' => (string) $user->name,
                'phone_number' => (string) $user->phone_number,
            ]);
        }

        if ($user->otp_expires_at < Carbon::now()) {
            return ApiResponse::error('Kode OTP sudah kedaluwarsa', 401, [
                'id' => (string) $user->id,
                'name' => (string) $user->name,
                'phone_number' => (string) $user->phone_number,
            ]);
        }

        DB::beginTransaction();

        try {
            $user->update([
                'status_akun' => 'aktif',
                'otp' => null,
                'otp_expires_at' => null,
            ]);

            $user->profile()->create([
                'tgl_lahir' => now(),
                'alamat' => '',
                'jenis_kelamin' => 'L',
                'total_points' => 0,
            ]);

            DB::commit();

            return ApiResponse::success('OTP berhasil diverifikasi', [
                'id' => (string) $user->id,
                'name' => (string) $user->name,
                'phone_number' => (string) $user->phone_number,
            ]);
        } catch (\Throwable $e) {
            DB::rollBack();
            return ApiResponse::error('Terjadi kesalahan saat verifikasi OTP', 500);
        }
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

        if ($user && $user->updated_at && $user->updated_at > now()->subMinute()) {
            return ApiResponse::error(
                'Kode OTP telah dikirim. Silakan tunggu sebentar.',
                429,
                [
                    // waktu tunggu = (updated_at + 60 detik) - sekarang
                    'retry_after' => (string) $user->updated_at->addMinute()->diffInSeconds(now())
                ]
            );
        }

        $otp = rand(1000, 9999);
        $otpExpiresAt = Carbon::now()->addMinutes(5);

        $user->update([
            'otp' => $otp,
            'otp_expires_at' => $otpExpiresAt,
        ]);

        return ApiResponse::success('Kode OTP baru telah dikirim', [
            'otp' => (string) $otp,
            'expired_in' => 300,
        ]);
    }
}
