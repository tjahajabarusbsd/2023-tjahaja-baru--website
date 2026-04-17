<?php

namespace App\Http\Controllers\Api\v1;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\VerifyOtpRequest;
use App\Services\Auth\AuthService;
use App\Services\PhoneNumberService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Throwable;

class AuthController extends Controller
{
    public function __construct(private AuthService $authService)
    {
    }

    public function register(RegisterRequest $request)
    {
        $phone = PhoneNumberService::normalize($request->phone_number);
        $existingUser = $this->authService->findUserByPhone($phone);

        if ($existingUser && $existingUser->status_akun === 'aktif') {
            return ApiResponse::error('Nomor sudah terdaftar.', 409);
        }

        $remaining = $this->authService->getOtpCooldownSeconds($existingUser);
        if ($remaining !== null) {
            return ApiResponse::error(
                "Kode OTP telah dikirim. Silakan tunggu dalam {$remaining} detik lagi.",
                429
            );
        }

        try {
            $user = $this->authService->register($request, $phone, $existingUser);
            Log::info('User ' . $user->id . ', status: ' . $user->status_akun . ', berhasil melakukan registrasi. OTP dikirim ke ' . $phone);
        } catch (Throwable $e) {
            Log::error('Registrasi user gagal', [
                'phone' => $phone,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            if ($e->getMessage() === 'WhatsApp API call failed.') {
                return ApiResponse::error('Gagal mengirim kode verifikasi. Silakan periksa nomor Anda dan coba lagi.', 500);
            }

            return ApiResponse::error('Terjadi kesalahan saat proses pendaftaran. Silakan coba lagi.', 500);
        }

        return ApiResponse::success(
            'Silakan verifikasi kode OTP yang telah dikirim ke WhatsApp Anda.',
            $this->authService->buildUserPayload($user, true)
        );
    }

    public function verifyOtpRegister(VerifyOtpRequest $request)
    {
        $phone = PhoneNumberService::normalize($request->phone_number);
        $user = $this->authService->findUserByPhone($phone);

        if (!$user) {
            Log::warning('Verifikasi OTP untuk register gagal: nomor tidak ditemukan - ' . $phone);
            return ApiResponse::error('Nomor Handphone tidak ditemukan', 404);
        }

        if (!$user->otp || !$user->otp_expires_at) {
            Log::error('Verifikasi OTP untuk register gagal: OTP belum dikirim untuk user ' . $user->id);
            return ApiResponse::error('Kode OTP belum dikirim. Silakan minta kode OTP terlebih dahulu.', 400);
        }

        if ($user->otp_expires_at->isPast()) {
            $user->update([
                'otp' => null,
                'otp_expires_at' => null,
            ]);

            Log::info('Kode OTP register sudah kedaluwarsa untuk user ' . $user->id . ' (Phone: ' . $phone . ')');
            return ApiResponse::error('Kode OTP sudah kedaluwarsa. Silakan minta kode baru.', 401);
        }

        if (!Hash::check($request->otp, $user->otp)) {
            Log::warning('Percobaan verifikasi OTP register, gagal untuk user ' . $user->id . ' (Phone: ' . $phone . ')');
            return ApiResponse::error('Kode OTP salah.', 401);
        }

        try {
            $user = $this->authService->verifyRegistrationOtp($user);
            Log::info('User ' . $user->id . ' berhasil mengaktifkan akun melalui OTP.');
        } catch (Throwable $e) {
            Log::error('Proses verifikasi OTP register, gagal untuk user ' . $user->id . ': ' . $e->getMessage());
            return ApiResponse::error('Terjadi kesalahan saat verifikasi OTP', 500);
        }

        return ApiResponse::success(
            'OTP berhasil diverifikasi',
            $this->authService->buildUserPayload($user)
        );
    }

    public function login(LoginRequest $request)
    {
        $phone = PhoneNumberService::normalize($request->phone_number);
        $user = $this->authService->findUserByPhone($phone);

        if (!$user) {
            return ApiResponse::error('Nomor Handphone belum terdaftar', 404);
        }

        if ($user->status_akun !== 'aktif') {
            return ApiResponse::error('Akun Anda belum aktif. Silakan verifikasi OTP terlebih dahulu.', 403);
        }

        if (!Hash::check($request->password, $user->password)) {
            return ApiResponse::error('Password tidak cocok', 401);
        }

        try {
            $token = $this->authService->login($user);
        } catch (Throwable $e) {
            Log::error('Login gagal untuk user ' . $user->id . ': ' . $e->getMessage());
            return ApiResponse::error('Terjadi kesalahan saat login. Silakan coba lagi.', 500);
        }

        return ApiResponse::success(
            'Login berhasil',
            $this->authService->buildUserPayload($user, false, ['token' => $token])
        );
    }

    public function logout(Request $request)
    {
        $user = $request->user();

        if (!$user) {
            return ApiResponse::error('User tidak ditemukan', 404);
        }

        $this->authService->logout($user);

        return ApiResponse::success('Logout berhasil');
    }

    public function updateFcmToken(Request $request)
    {
        $validated = $request->validate([
            'fcm_token' => 'required|string',
        ]);

        try {
            $this->authService->updateFcmToken($request->user(), $validated['fcm_token']);
        } catch (Throwable $e) {
            Log::error('Gagal update FCM token: ' . $e->getMessage());

            if ($e instanceof ModelNotFoundException) {
                return ApiResponse::error('User tidak ditemukan', 404);
            }

            return ApiResponse::error('Terjadi kesalahan server', 500);
        }

        return ApiResponse::success('FCM token berhasil diperbarui');
    }
}
