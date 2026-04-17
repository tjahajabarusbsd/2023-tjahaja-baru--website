<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Services\PhoneNumberService;
use App\Services\OtpService;
use App\Models\UserPublic;
use App\Helpers\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Exception;

class OtpController extends Controller
{
    public function resendOtpRegister(Request $request, OtpService $otpService)
    {
        $phone = PhoneNumberService::normalize($request->phone_number);

        $user = UserPublic::where('phone_number', $phone)->first();

        if (!$user) {
            return ApiResponse::error('Akun tidak ditemukan', 404);
        }

        if ($user->status_akun === 'aktif') {
            return ApiResponse::error('Akun sudah aktif', 400);
        }

        if ($user->last_otp_sent_at && $user->last_otp_sent_at > now()->subMinute()) {
            $remaining = now()->diffInSeconds(
                $user->last_otp_sent_at->copy()->addMinute()
            );
            return ApiResponse::error(
                "Kode OTP telah dikirim. Silakan tunggu dalam {$remaining} detik lagi.",
                429
            );
        }

        try {
            $otpService->sendOtp($user, 'register', $phone);

            Log::info('Resend OTP register sent successfully', [
                'user_id' => $user->id,
                'phone' => $phone,
            ]);

        } catch (Exception $e) {
            Log::error('Resend OTP register process failed', [
                'user_id' => $user->id ?? null,
                'error' => $e->getMessage(),
                'trace' => app()->environment('local') ? $e->getTraceAsString() : null,
            ]);
            return ApiResponse::error('Gagal mengirim OTP', 500);
        }

        return ApiResponse::success('Kode OTP telah dikirim', [
            'expired_in' => $otpService->getExpirySeconds(),
        ]);
    }

    public function resendOtpForgotPassword(Request $request, OtpService $otpService)
    {
        $phone = PhoneNumberService::normalize($request->phone_number);

        $user = UserPublic::where('phone_number', $phone)->first();

        if (!$user) {
            Log::warning('Resend OTP forgot password failed - user not found', [
                'phone' => $phone,
            ]);
            return ApiResponse::error('Akun tidak ditemukan', 404);
        }

        if ($user->status_akun !== 'aktif') {
            Log::warning('Resend OTP forgot password failed - account not active', [
                'user_id' => $user->id,
                'phone' => $phone,
                'status_akun' => $user->status_akun,
            ]);
            return ApiResponse::error('Akun belum aktif. Tidak bisa reset password.', 400);
        }

        if ($user->last_otp_sent_at && $user->last_otp_sent_at > now()->subMinute()) {
            $remaining = now()->diffInSeconds(
                $user->last_otp_sent_at->copy()->addMinute()
            );

            return ApiResponse::error(
                "Kode OTP telah dikirim. Silakan tunggu dalam {$remaining} detik lagi.",
                429
            );
        }

        try {
            $otpService->sendOtp($user, 'forgot_password', $phone);

            Log::info('Resend OTP forgot password sent successfully', [
                'user_id' => $user->id,
                'phone' => $phone,
            ]);

            return ApiResponse::success('Kode OTP telah dikirim', [
                'expired_in' => $otpService->getExpirySeconds(),
            ]);

        } catch (Exception $e) {
            Log::error('Resend OTP forgot password process failed', [
                'user_id' => $user->id ?? null,
                'error' => $e->getMessage(),
                'trace' => app()->environment('local') ? $e->getTraceAsString() : null,
            ]);
            return ApiResponse::error('Gagal mengirim OTP', 500);
        }
    }

    public function resendOtpChangeNumber(Request $request, OtpService $otpService)
    {
        $user = Auth::user();

        if (!$user) {
            return ApiResponse::error('Unauthorized', 401);
        }

        $validator = Validator::make($request->all(), [
            'new_phone_number' => [
                'required',
                'string',
                'regex:/^(\+62|62|0)8[1-9][0-9]{7,10}$/',
            ],
        ], [
            'new_phone_number.required' => 'Nomor HP baru wajib diisi',
            'new_phone_number.string' => 'Nomor HP baru harus berupa teks',
            'new_phone_number.regex' => 'Format nomor HP tidak valid',
        ]);

        if ($validator->fails()) {
            return ApiResponse::error($validator->errors()->first(), 422);
        }

        $phone = PhoneNumberService::normalize($request->new_phone_number);
        if ($phone === $user->phone_number) {
            return ApiResponse::error('Nomor HP baru sama dengan nomor saat ini', 400);
        }

        $phoneExists = UserPublic::where('phone_number', $phone)->where('id', '!=', $user->id)->exists();
        if ($phoneExists) {
            return ApiResponse::error('Nomor HP baru sudah digunakan.', 400);
        }

        $existingRequest = $user->phoneChangeRequest;
        if ($existingRequest && $existingRequest->last_otp_sent_at > now()->subMinute()) {
            $remaining = now()->diffInSeconds(
                $existingRequest->last_otp_sent_at->copy()->addMinute()
            );
            return ApiResponse::error(
                "Kode OTP telah dikirim. Silakan tunggu dalam {$remaining} detik lagi.",
                429
            );
        }

        try {
            $otpService->sendOtp($user, 'change_phone', $phone);

            Log::info('Resend OTP change phone sent successfully', [
                'user_id' => $user->id,
                'phone' => $phone,
            ]);

        } catch (Exception $e) {
            Log::error('Resend OTP change phone process failed', [
                'user_id' => $user->id ?? null,
                'error' => $e->getMessage(),
                'trace' => app()->environment('local') ? $e->getTraceAsString() : null,
            ]);
            return ApiResponse::error('Gagal mengirim OTP', 500);
        }

        return ApiResponse::success('Kode OTP telah dikirim', [
            'expired_in' => $otpService->getExpirySeconds(),
        ]);
    }
}
