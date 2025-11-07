<?php

namespace App\Http\Controllers\Api\v1;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\UserPublic;
use App\Services\PhoneNumberService;
use App\Services\OtpService;
use App\Services\WhatsAppService;

class AuthController extends Controller
{
    public function register(RegisterRequest $request, OtpService $otpService, WhatsAppService $whatsAppService)
    {
        $phone = PhoneNumberService::normalize($request->phone_number);

        $existingUser = UserPublic::where('phone_number', $phone)->first();
        if ($existingUser && $existingUser->status_akun === 'aktif') {
            return ApiResponse::error('Nomor sudah terdaftar dan aktif', 409);
        }

        DB::beginTransaction();
        try {
            $otpPlain = $otpService->generateOtpWithoutFour();
            $otpHash = $otpService->hashOtp($otpPlain);
            $expiry = $otpService->expiryTime();

            // Simpan / Update Data User
            if ($existingUser) {
                // Jika user ada tapi mungkin statusnya 'tidak aktif' atau 'pending'
                $existingUser->update([
                    'otp' => $otpHash,
                    'otp_expires_at' => $expiry,
                    'password' => Hash::make($request->password),
                    'status_akun' => 'pending',
                ]);
                $user = $existingUser;
            } else {
                // Jika user benar-benar baru
                $user = UserPublic::create([
                    'name' => $request->name,
                    'phone_number' => $phone,
                    'password' => Hash::make($request->password),
                    'status_akun' => 'pending',
                    'login_method' => 'manual',
                    'otp' => $otpHash,
                    'otp_expires_at' => $expiry,
                ]);
            }

            // Kirim OTP via WhatsApp SETELAH Data Tersimpan
            $messageBody = $otpService->buildMessage($otpPlain);
            $apiResponse = $whatsAppService->send($phone, $messageBody);

            // Cek response dari WhatsApp API
            if ($apiResponse->failed()) {
                // Jika gagal kirim, batalkan semua perubahan di database
                DB::rollBack();

                Log::error('WhatsApp API Failed during phone change for user ' . $user->id, [
                    'phone' => $phone,
                    'response_body' => $apiResponse->body(),
                    'status' => $apiResponse->status(),
                ]);

                return ApiResponse::error('Gagal mengirim kode verifikasi. Silakan periksa nomor Anda dan coba lagi.', 500);
            }

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();

            Log::error('User registration failed', [
                'phone' => $phone,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return ApiResponse::error('Terjadi kesalahan saat proses pendaftaran. Silakan coba lagi.', 500);
        }

        // Return Response Sukses
        // Refresh model untuk mendapatkan data terbaru setelah commit
        $user->refresh();

        return ApiResponse::success('Pendaftaran berhasil. Silakan verifikasi kode OTP yang telah dikirim ke WhatsApp Anda.', [
            'id' => (string) $user->id,
            'name' => (string) $user->name,
            'phone_number' => (string) $user->phone_number,
            'status_akun' => $user->status_akun,
            'created_at' => $user->created_at->toISOString(),
            'updated_at' => $user->updated_at->toISOString(),
        ]);
    }

    public function login(LoginRequest $request)
    {
        // Normalisasi nomor agar sama dengan format di database
        $phone = PhoneNumberService::normalize($request->phone_number);

        $user = UserPublic::where('phone_number', $phone)->first();

        if (!$user) {
            return ApiResponse::error('Nomor Handphone belum terdaftar', 404);
        }

        if (!Hash::check($request->password, $user->password)) {
            return ApiResponse::error('Password tidak cocok', 401);
        }

        // Batasi maksimal 3 token aktif
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
            return ApiResponse::error($validator->errors()->first(), 422);
        }

        $phone = PhoneNumberService::normalize($request->phone_number);
        $user = UserPublic::where('phone_number', $phone)->first();

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

    public function updateFcmToken(Request $request)
    {
        $request->validate([
            'fcm_token' => 'required|string',
        ]);

        try {
            $user = auth()->user(); // pastikan pakai sanctum/jwt

            if (!$user) {
                return response()->json(['success' => false, 'message' => 'User tidak ditemukan'], 401);
            }

            $user->fcm_token = $request->fcm_token;
            $user->save();

            return response()->json([
                'success' => true,
                'message' => 'FCM token berhasil diperbarui',
            ]);
        } catch (\Exception $e) {
            \Log::error('Gagal update FCM token: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan server',
            ], 500);
        }
    }
}
