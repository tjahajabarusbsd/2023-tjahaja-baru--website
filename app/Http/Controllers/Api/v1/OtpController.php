<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\VerifyOtpRequest;
use App\Http\Requests\SendOtpRequest;
use App\Services\PhoneNumberService;
use App\Services\OtpService;
use App\Models\UserPublic;
use App\Helpers\ApiResponse;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\WhatsAppController;

class OtpController extends Controller
{
    public function verifyOtp(VerifyOtpRequest $request)
    {
        $phone = PhoneNumberService::normalize($request->phone_number);
        $user = UserPublic::where('phone_number', $phone)->first();

        // Cek apakah user ada
        if (!$user) {
            Log::warning('Percobaan verifikasi OTP untuk nomor tidak dikenal: ' . $phone);
            return ApiResponse::error('Nomor Handphone tidak ditemukan', 404);
        }

        // Cek apakah OTP sudah kadaluarsa
        if ($user->otp_expires_at->isPast()) {
            // Hapus OTP yang sudah kadaluarsa untuk keamanan
            $user->update([
                'otp' => null,
                'otp_expires_at' => null,
            ]);
            return ApiResponse::error('Kode OTP sudah kedaluwarsa. Silakan minta kode baru.', 401);
        }

        // Verifikasi OTP 
        if (!Hash::check($request->otp, $user->otp)) {
            Log::warning('Percobaan verifikasi OTP gagal untuk user ' . $user->id . ' (Phone: ' . $phone . ')');
            return ApiResponse::error('Kode OTP salah.', 401);
        }

        // Proses verifikasi berdasarkan tipe
        try {
            $response = []; // Inisialisasi response untuk mencegah undefined variable

            if ($request->type === 'register') {
                $user->update([
                    'status_akun' => 'aktif',
                    'otp' => null,
                    'otp_expires_at' => null,
                ]);

                if (!$user->profile) {
                    $user->profile()->create([
                        'tgl_lahir' => null,
                        'alamat' => null,
                        'jenis_kelamin' => null,
                        'total_points' => 0,
                    ]);
                }

                $response = [
                    'id' => (string) $user->id,
                    'name' => (string) $user->name,
                    'phone_number' => (string) $user->phone_number,
                    'status' => 'otp_register_verified',
                ];
            } elseif ($request->type === 'lupa_password') {
                $user->update([
                    'otp' => null,
                    'otp_expires_at' => null,
                ]);

                $response = [
                    'id' => (string) $user->id,
                    'name' => (string) $user->name,
                    'phone_number' => (string) $user->phone_number,
                    'status' => 'otp_forgot_password_verified',
                ];
            } else {
                Log::error('Verifikasi OTP dengan type tidak valid untuk user ' . $user->id . ': ' . $request->type);
                return ApiResponse::error('Tipe verifikasi tidak valid.', 400);
            }

        } catch (\Throwable $e) {
            Log::error('Gagal proses verifikasi OTP untuk user ' . $user->id . ': ' . $e->getMessage());
            return ApiResponse::error('Terjadi kesalahan saat verifikasi OTP', 500);
        }

        $user->refresh();

        return ApiResponse::success('OTP berhasil diverifikasi', $response);
    }

    public function sendOtp(SendOtpRequest $request, WhatsAppController $whatsAppController, OtpService $otpService)
    {
        $user = UserPublic::where('phone_number', $request->phone_number)->first();

        if (!$user) {
            return ApiResponse::error('Nomor Handphone belum terdaftar', 404);
        }

        if ($request->type === 'register' && $user->status_akun === 'aktif') {
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
                    'retry_after' => (string) $user->updated_at->addMinute()->diffInSeconds(now())
                ]
            );
        }

        $otp = $otpService->generateOtpWithoutFour();
        $expiry = $otpService->expiryTime();
        $phone = PhoneNumberService::normalize($request->phone_number);
        $messageBody = $otpService->buildMessage($otp);

        $apiResponse = $whatsAppController->sendWhatsAppMessage($phone, $messageBody);

        if (!method_exists($apiResponse, 'getStatusCode') || $apiResponse->getStatusCode() !== 200) {
            DB::rollBack();
            return ApiResponse::error('Gagal mengirim OTP. Silakan coba lagi.', 500, [
                'details' => $apiResponse
            ]);
        }

        $user->update([
            'otp' => $otp,
            'otp_expires_at' => $expiry,
        ]);

        return ApiResponse::success('Kode OTP telah dikirim', [
            'otp' => (string) $otp,
            'expired_in' => $otpService->getExpirySeconds(),
        ]);
    }
}
