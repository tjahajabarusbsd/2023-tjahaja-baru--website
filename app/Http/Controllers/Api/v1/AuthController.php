<?php

namespace App\Http\Controllers\Api\v1;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;
use App\Models\UserPublic;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $otp = rand(1000, 9999);
        $otpExpiresAt = Carbon::now()->addMinutes(5);

        DB::beginTransaction();

        try {
            $user = UserPublic::where('phone_number', $request->phone_number)->first();

            if ($user) {
                if ($user->status_akun === 'aktif') {
                    return ApiResponse::error('Nomor sudah terdaftar dan aktif', 409);
                }

                $user->update([
                    'otp' => $otp,
                    'otp_expires_at' => $otpExpiresAt,
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
                    'otp_expires_at' => $otpExpiresAt,
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
}
