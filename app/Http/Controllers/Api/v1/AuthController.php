<?php

namespace App\Http\Controllers\Api\v1;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Services\PhoneNumberService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;
use App\Models\UserPublic;
use Illuminate\Support\Facades\DB;
use App\Services\OtpService;
use App\Http\Controllers\WhatsAppController;

class AuthController extends Controller
{
    public function register(RegisterRequest $request, OtpService $otpService, WhatsAppController $whatsAppController)
    {
        DB::beginTransaction();

        try {
            $user = UserPublic::where('phone_number', $request->phone_number)->first();

            $otp = $otpService->generateOtpWithoutFour();
            $expiry = $otpService->expiryTime();
            $phone = PhoneNumberService::normalize($request->phone_number);
            $messageBody = $otpService->buildMessage($otp);

            $apiResponse = $whatsAppController->sendWhatsAppMessage($phone, $messageBody);

            // cek response WA (pastikan format return sesuai)
            if (!method_exists($apiResponse, 'getStatusCode') || $apiResponse->getStatusCode() !== 200) {
                DB::rollBack();
                return ApiResponse::error('Gagal mengirim OTP. Silakan coba lagi.', 500, [
                    'details' => $apiResponse
                ]);
            }

            if ($user) {
                if ($user->status_akun === 'aktif') {
                    return ApiResponse::error('Nomor sudah terdaftar dan aktif', 409);
                }

                $user->update([
                    'otp' => $otp,
                    'otp_expires_at' => $expiry,
                    'password' => Hash::make($request->password),
                ]);

            } else {
                $user = UserPublic::create([
                    'name' => $request->name,
                    'phone_number' => $request->phone_number,
                    'password' => Hash::make($request->password),
                    'status_akun' => 'pending',
                    'login_method' => 'manual',
                    'otp' => $otp,
                    'otp_expires_at' => $expiry,
                ]);
            }

            DB::commit();

            return ApiResponse::success('Register berhasil, silakan verifikasi OTP', [
                'id' => (string) $user->id,
                'name' => (string) $user->name,
                'phone_number' => (string) $user->phone_number,
                'otp' => (string) $otp,
                'created_at' => Carbon::now()->toISOString(),
                'updated_at' => Carbon::now()->toISOString(),
            ]);
        } catch (\Throwable $e) {
            DB::rollBack();

            \Log::error('Register gagal', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return ApiResponse::error('Terjadi kesalahan saat register', 500);
        }
    }

    public function login(LoginRequest $request)
    {
        $user = UserPublic::where('phone_number', $request->phone_number)->first();

        if (!$user) {
            return ApiResponse::error('Nomor Handphone belum terdaftar', 404);
        }

        if (!Hash::check($request->password, $user->password)) {
            return ApiResponse::error('Password tidak cocok', 401);
        }

        $user->tokens()->when($user->tokens()->count() >= 3, function ($query) {
            $query->oldest()->first()?->delete();
        });

        $token = $user->createToken('auth_mobile_token')->plainTextToken;

        return ApiResponse::success('Login berhasil', [
            'id' => (string) $user->id,
            'name' => (string) $user->name,
            'phone_number' => (string) $user->phone_number,
            'token' => (string) $token,
        ]);
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
            $errorMessages = implode(' ', $validator->errors()->all());

            return response()->json([
                'status' => 'error',
                'code' => 422,
                'message' => $errorMessages,
                'data' => null,
            ], 422);
        }

        $user = UserPublic::where('phone_number', $request->phone_number)->first();

        if (!$user) {
            return ApiResponse::error('Nomor Handphone belum terdaftar', 404);
        }

        // (Opsional) cek kalau otp dan otp_expires_at memang sudah null
        if ($user->otp || $user->otp_expires_at) {
            return ApiResponse::error('OTP belum diverifikasi.', 403);
        }

        $user->update([
            'password' => Hash::make($request->new_password),
        ]);

        return ApiResponse::success('Password berhasil diubah.', [
            'id' => (string) $user->id,
            'updated_at' => now()->toISOString(),
        ]);
    }

    public function logout(Request $request)
    {
        $user = $request->user();

        if ($user) {
            $user->tokens()->delete();
            return ApiResponse::success('Logout berhasil');
        }

        return ApiResponse::error('User tidak ditemukan', 404);
    }

    public function loginGoogle(Request $request)
    {
        $request->validate([
            'idToken' => 'required|string',
        ]);

        try {
            // 1. Verifikasi token ke Google
            $response = Http::get("https://oauth2.googleapis.com/tokeninfo", [
                'id_token' => $request->idToken,
            ]);

            if ($response->failed()) {
                return ApiResponse::error('ID Token tidak valid', 401);
            }

            $googleData = $response->json();

            // Data penting dari Google
            $googleId = $googleData['sub'];       // unique google user id
            $email = $googleData['email'] ?? null;
            $name = $googleData['name'] ?? 'User Google';

            if (!$email) {
                return ApiResponse::error('Email dari Google tidak ditemukan', 422);
            }

            DB::beginTransaction();

            // 2. Cari user di DB
            $user = UserPublic::where('google_id', $googleId)
                ->orWhere('email', $email)
                ->first();

            if (!$user) {
                // 3. Buat user baru
                $user = UserPublic::create([
                    'name' => $name,
                    'email' => $email,
                    'google_id' => $googleId,
                    'status_akun' => 'aktif',
                    'login_method' => 'google',
                ]);
                $user->profile()->create([
                    'tgl_lahir' => now(),
                    'alamat' => '',
                    'jenis_kelamin' => 'L',
                    'total_points' => 0,
                ]);
            } else {
                // 4. Update data user lama
                $user->update([
                    'google_id' => $googleId,
                    'name' => $name,
                    'login_method' => 'google',
                    'status_akun' => 'aktif',
                ]);
            }

            // 5. Buat token aplikasi (gunakan Sanctum/Passport sesuai setupmu)
            $token = $user->createToken('auth_google_token')->plainTextToken;

            DB::commit();

            return ApiResponse::success('Login Google berhasil', [
                'id' => (string) $user->id,
                'name' => (string) $user->name,
                'email' => (string) $user->email,
                'google_id' => (string) $user->google_id,
                'login_method' => (string) $user->login_method,
                'token' => $token,
                'updated_at' => Carbon::now()->toISOString(),
            ]);
        } catch (\Throwable $e) {
            DB::rollBack();
            return ApiResponse::error('Terjadi kesalahan saat login Google: ' . $e->getMessage(), 500);
        }
    }

    public function loginFacebook(Request $request)
    {
        DB::beginTransaction();

        try {
            $facebookId = $request->input('facebook_id');
            $name = $request->input('name');
            $email = $request->input('email');

            if (!$facebookId) {
                return ApiResponse::error('Facebook ID wajib dikirim', 400);
            }

            // 1. Cari user berdasarkan facebook_id
            $user = UserPublic::where('facebook_id', $facebookId)->first();

            // 2. Kalau belum ada, cek pakai email
            if (!$user && $email) {
                $user = UserPublic::where('email', $email)->first();
            }

            // 3. Kalau user belum ada → buat baru
            if (!$user) {
                $user = UserPublic::create([
                    'name' => $name ?? 'User FB',
                    'email' => $email,
                    'facebook_id' => $facebookId,
                    'status_akun' => 'aktif',
                    'login_method' => 'facebook',
                ]);

                // Buat profile default
                $user->profile()->create([
                    'tgl_lahir' => now(),
                    'alamat' => '',
                    'jenis_kelamin' => 'L',
                    'total_points' => 0,
                ]);
            }

            // 4. Generate token Sanctum
            $token = $user->createToken('auth_facebook_token')->plainTextToken;

            DB::commit();

            return ApiResponse::success('Login Facebook berhasil', [
                'id' => (string) $user->id,
                'name' => (string) $user->name,
                'email' => (string) $user->email,
                'token' => $token,
                'login_method' => $user->login_method,
            ]);
        } catch (\Throwable $e) {
            DB::rollBack();
            return ApiResponse::error('Terjadi kesalahan saat login Facebook: ' . $e->getMessage(), 500);
        }
    }

}
