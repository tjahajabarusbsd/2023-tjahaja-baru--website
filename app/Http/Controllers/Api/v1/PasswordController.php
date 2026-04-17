<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Helpers\ApiResponse;
use App\Services\PhoneNumberService;
use App\Services\OtpService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use App\Models\UserPublic;
use Exception;
use Illuminate\Support\Str;

class PasswordController extends Controller
{
    public function forgotPassword(Request $request, OtpService $otpService)
    {
        $validator = Validator::make($request->all(), [
            'phone_number' => [
                'required',
                'string',
                'regex:/^(\+62|62|0)8[1-9][0-9]{7,10}$/',
            ],
        ], [
            'phone_number.required' => 'Nomor handphone wajib diisi',
            'phone_number.string' => 'Nomor handphone harus berupa teks',
            'phone_number.regex' => 'Format nomor handphone tidak valid',
        ]);

        if ($validator->fails()) {
            return ApiResponse::error($validator->errors()->first(), 422);
        }

        $phone = PhoneNumberService::normalize($request->phone_number);

        $existingUser = UserPublic::where('phone_number', $phone)->first();
        if (!$existingUser) {
            return ApiResponse::error('Nomor belum terdaftar, silakan daftar terlebih dahulu', 404);
        }

        if (
            $existingUser->last_otp_sent_at &&
            $existingUser->last_otp_sent_at > now()->subMinute()
        ) {
            $remaining = now()->diffInSeconds(
                $existingUser->last_otp_sent_at->copy()->addMinute()
            );
            return ApiResponse::error(
                "Kode OTP telah dikirim. Silakan tunggu dalam {$remaining} detik lagi.",
                429
            );
        }

        try {
            $otpService->sendOtp($existingUser, 'forgot_password', $phone);

            Log::info('OTP untuk lupa password berhasil dikirim', [
                'user_id' => $existingUser->id,
                'phone_number' => $phone,
            ]);
        } catch (Exception $e) {
            Log::error('Gagal mengirim OTP untuk lupa password ke user ' . $existingUser->id . ': ' . $e->getMessage());
            return ApiResponse::error('Gagal mengirim OTP', 500);
        }

        return ApiResponse::success('OTP berhasil dikirim ke WhatsApp Anda');
    }

    public function verifyOtpForgotPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone_number' => [
                'required',
                'string',
                'regex:/^(\+62|62|0)8[1-9][0-9]{7,10}$/',
            ],
            'otp' => 'required|string',
        ], [
            'phone_number.required' => 'Nomor handphone wajib diisi',
            'phone_number.string' => 'Nomor handphone harus berupa teks',
            'phone_number.regex' => 'Format nomor handphone tidak valid',
            'otp.required' => 'Kode OTP wajib diisi',
            'otp.string' => 'Kode OTP harus berupa teks',
        ]);

        if ($validator->fails()) {
            return ApiResponse::error($validator->errors()->first(), 422);
        }

        $phone = PhoneNumberService::normalize($request->phone_number);
        $user = UserPublic::where('phone_number', $phone)->first();

        if (!$user) {
            Log::error('Verifikasi OTP untuk lupa password gagal: nomor tidak ditemukan - ' . $phone);
            return ApiResponse::error('Nomor Handphone tidak ditemukan', 404);
        }

        if (!$user->otp || !$user->otp_expires_at) {
            Log::error('Verifikasi OTP untuk lupa password gagal: OTP belum dikirim untuk user ' . $user->id);
            return ApiResponse::error('Kode OTP belum dikirim. Silakan minta kode OTP terlebih dahulu.', 400);
        }

        if ($user->otp_expires_at->isPast()) {
            $user->update([
                'otp' => null,
                'otp_expires_at' => null,
            ]);
            Log::info('Kode OTP lupa password sudah kedaluwarsa untuk user ' . $user->id . ' (Phone: ' . $phone . ')');
            return ApiResponse::error('Kode OTP sudah kedaluwarsa. Silakan minta kode baru.', 400);
        }

        if (!Hash::check($request->otp, $user->otp)) {
            Log::warning('Percobaan verifikasi OTP lupa password, gagal untuk user ' . $user->id . ' (Phone: ' . $phone . ')');
            return ApiResponse::error('Kode OTP salah.', 401);
        }

        if ($user->status_akun !== 'aktif') {
            return ApiResponse::error('Akun belum aktif.', 403);
        }

        $token = Str::random(64);
        Log::info('Password reset token generated', [
            'user_id' => $user->id,
        ]);

        $user->update([
            'otp' => null,
            'otp_expires_at' => null,
            'last_otp_sent_at' => null,
            'password_reset_token' => hash('sha256', $token),
            'password_reset_expires_at' => now()->addMinutes(10),
        ]);

        Log::info('User ' . $user->id . ' berhasil memverifikasi OTP untuk lupa password.');

        $response = [
            'id' => (string) $user->id,
            'name' => (string) $user->name,
            'phone_number' => (string) $user->phone_number,
            'reset_token' => $token,
        ];

        return ApiResponse::success('OTP berhasil diverifikasi', $response);
    }

    public function resetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone_number' => [
                'required',
                'string',
                'regex:/^(\+62|62|0)8[1-9][0-9]{7,10}$/',
            ],
            'new_password' => 'required|min:8|confirmed',
        ], [
            'phone_number.required' => 'Nomor handphone wajib diisi',
            'phone_number.string' => 'Nomor handphone harus berupa teks',
            'phone_number.regex' => 'Format nomor handphone tidak valid',
            'new_password.required' => 'Password baru wajib diisi',
            'new_password.min' => 'Password minimal 8 karakter',
            'new_password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        if ($validator->fails()) {
            return ApiResponse::error($validator->errors()->first(), 422);
        }

        $phone = PhoneNumberService::normalize($request->phone_number);

        $hashedToken = hash('sha256', $request->reset_token);

        $user = UserPublic::where('phone_number', $phone)
            ->where('password_reset_token', $hashedToken)
            ->first();

        if (!$user) {
            Log::warning('Percobaan reset password gagal karena token tidak valid untuk user ' . $user->id . ' (Phone: ' . $phone . ')');
            return ApiResponse::error('Token tidak valid', 401);
        }

        if (!$user->password_reset_expires_at || $user->password_reset_expires_at->isPast()) {
            Log::warning('Percobaan reset password gagal karena token sudah kedaluwarsa untuk user ' . $user->id . ' (Phone: ' . $phone . ')');
            return ApiResponse::error('Token sudah kedaluwarsa', 401);
        }

        if ($user->status_akun !== 'aktif') {
            Log::warning('Percobaan reset password gagal karena akun tidak aktif untuk user ' . $user->id . ' (Phone: ' . $phone . ')');
            return ApiResponse::error('Akun Anda tidak aktif.', 403);
        }

        try {
            $user->update([
                'password' => Hash::make($request->new_password),
                'password_reset_token' => null,
                'password_reset_expires_at' => null,
            ]);

            Log::info('Password berhasil diubah untuk user ' . $user->id);
        } catch (Exception $e) {
            Log::error('Gagal mengubah password untuk user ' . $user->id . ': ' . $e->getMessage());
            return ApiResponse::error('Terjadi kesalahan saat mengubah password', 500);
        }

        return ApiResponse::success('Password berhasil diubah.', [
            'id' => (string) $user->id,
            'updated_at' => now()->toISOString(),
        ]);
    }
}