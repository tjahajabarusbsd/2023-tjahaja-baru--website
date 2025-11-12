<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\VerifyOtpRequest;
use App\Http\Requests\SendOtpRequest;
use App\Services\PhoneNumberService;
use App\Services\OtpService;
use App\Services\WhatsAppService;
use App\Models\UserPublic;
use App\Helpers\ApiResponse;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Exception;

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

        // Cek apakah OTP sudah tidak ada (null)
        if (empty($user->otp) || empty($user->otp_expires_at)) {
            return ApiResponse::error('Kode OTP sudah tidak berlaku. Silakan minta kode baru.', 400);
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
                    'last_otp_sent_at' => null,
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
                    'last_otp_sent_at' => null,
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

    public function sendOtp(SendOtpRequest $request, WhatsAppService $whatsAppService, OtpService $otpService)
    {
        $phone = PhoneNumberService::normalize($request->phone_number);
        $user = UserPublic::where('phone_number', $phone)->first();

        if (!$user) {
            return ApiResponse::error('Nomor Handphone belum terdaftar.', 404);
        }

        if ($request->type === 'register' && $user->status_akun === 'aktif') {
            return ApiResponse::error('Akun sudah aktif. Tidak perlu verifikasi ulang.', 400);
        }

        if ($request->type === 'lupa_password' && $user->status_akun !== 'aktif') {
            return ApiResponse::error('Akun belum aktif. Tidak bisa reset password.', 400);
        }

        if ($user->last_otp_sent_at && $user->last_otp_sent_at > now()->subMinute()) {
            return ApiResponse::error(
                'Kode OTP telah dikirim. Silakan tunggu sebentar.',
                429,
                [
                    'retry_after' => (string) $user->last_otp_sent_at->addMinute()->diffInSeconds(now())
                ]
            );
        }

        DB::beginTransaction();
        try {
            $otpPlain = $otpService->generateOtpWithoutFour();
            $otpHash = $otpService->hashOtp($otpPlain);
            $expiry = $otpService->expiryTime();

            $messageBody = $otpService->buildMessage($otpPlain);
            $apiResponse = $whatsAppService->send($phone, $messageBody);

            if ($apiResponse->failed()) {
                Log::error('WhatsApp API Failed during OTP send for user ' . $user->id, [
                    'phone' => $phone,
                    'response_body' => $apiResponse->body(),
                    'status' => $apiResponse->status(),
                ]);

                throw new Exception('WhatsApp API call failed.');
            }

            $user->update([
                'otp' => $otpHash,
                'otp_expires_at' => $expiry,
                'last_otp_sent_at' => now(),
            ]);

            DB::commit();

            Log::info('OTP sent successfully', [
                'user_id' => $user->id,
                'phone' => $phone,
                'type' => $request->type,
            ]);

            return ApiResponse::success('Kode OTP telah dikirim', [
                'expired_in' => $otpService->getExpirySeconds(),
            ]);

        } catch (Exception $e) {
            DB::rollBack();

            Log::error('OTP sending process failed for user ' . ($user->id ?? 'unknown'), [
                'phone' => $phone,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return ApiResponse::error('Gagal mengirim kode verifikasi. Silakan coba lagi.', 500);
        }
    }
}
