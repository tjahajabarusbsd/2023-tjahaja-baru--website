<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;
use App\User;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'max:50', 'regex:/^[a-zA-Z\s]+$/'],
            'phone_number' => [
                'required',
                'string',
                'regex:/^(\+62|62|0)8[1-9][0-9]{7,10}$/',
                'unique:users,phone_number',
            ],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'password_confirmation' => 'required|string|min:8',
        ], [
            'name.required' => 'Nama wajib diisi',
            'name.string' => 'Nama harus berupa teks',
            'name.max' => 'Nama tidak boleh lebih dari :max karakter',
            'name.regex' => 'Nama wajib menggunakan huruf',
            'phone_number.required' => 'Nomor handphone wajib diisi',
            'phone_number.string' => 'Nomor handphone harus berupa teks',
            'phone_number.regex' => 'Format nomor handphone tidak valid',
            'phone_number.unique' => 'Nomor handphone sudah terdaftar',
            'password.required' => 'Password wajib diisi',
            'password.string' => 'Password harus berupa teks',
            'password.min' => 'Password minimal harus :min karakter',
            'password.confirmed' => 'Konfirmasi password tidak cocok',
        ]);

        if ($validator->fails()) {
            $firstError = $validator->errors()->first();

            return response()->json([
                'status' => 'error',
                'code' => 422,
                'message' => $firstError,
                'data' => null,
            ], 422);
        }

        $otp = rand(1000, 9999);
        // $otpExpiresAt = Carbon::now()->addMinutes(5);

        // Simpan user ke database
        $user = User::create([
            'name' => $request->name,
            'phone_number' => $request->phone_number,
            'password' => Hash::make($request->password),
            // 'otp' => $otp,
            // 'otp_expires_at' => $otpExpiresAt,
        ]);

        return response()->json([
            'status' => 'success',
            'code' => 200,
            'message' => 'Register berhasil',
            'data' => [
                'id' => (string) $user->id,
                'name' => (string) $request->name,
                'phone_number' => (string) $request->phone_number,
                'created_at' => Carbon::now()->toISOString(),
                'updated_at' => Carbon::now()->toISOString(),
                'otp' => (string) $otp,
                // 'otp_expired_in' => $otpExpiresAt->diffInSeconds(Carbon::now()),
            ]
        ]);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone_number' => [
                'required',
                'string',
                'regex:/^(\+62|62|0)8[1-9][0-9]{7,10}$/',
            ],
            'password' => 'required|string',
        ], [
            'phone_number.required' => 'Nomor handphone wajib diisi',
            'phone_number.string' => 'Nomor handphone harus berupa teks',
            'phone_number.regex' => 'Format nomor handphone tidak valid',
            'password.required' => 'Password wajib diisi',
            'password.string' => 'Password harus berupa teks',
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

        $user = User::where('phone_number', $request->phone_number)->first();

        if (!$user) {
            return response()->json([
                'status' => 'error',
                'code' => 404,
                'message' => 'Nomor Handphone belum terdaftar',
                'data' => null
            ], 404);
        }

        if (!Hash::check($request->password, $user->password)) {
            return response()->json([
                'status' => 'error',
                'code' => 401,
                'message' => 'Password tidak cocok',
                'data' => null
            ], 401);
        }

        if ($user->tokens()->count() >= 3) {
            $user->tokens()->oldest()->first()?->delete();
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'status' => 'success',
            'code' => 200,
            'message' => 'Login berhasil',
            'data' => [
                'id' => (string) $user->id,
                'name' => (string) $user->name,
                'phone_number' => (string) $user->phone_number,
                'token' => (string) $token,
            ]
        ]);
    }

    public function verifyOtp(Request $request)
    {
        $otp_hardcode = "1234"; // Hardcoded OTP for development purposes

        $validator = Validator::make($request->all(), [
            'phone_number' => [
                'required',
                'string',
                'regex:/^(\+62|62|0)8[1-9][0-9]{7,10}$/',
            ],
            'otp' => 'required|digits:4',
        ], [
            'phone_number.required' => 'Nomor handphone wajib diisi',
            'phone_number.string' => 'Nomor handphone harus berupa teks',
            'phone_number.regex' => 'Format nomor handphone tidak valid',
            'otp.required' => 'Kode OTP wajib diisi',
            'otp.digits' => 'Kode OTP harus terdiri dari 4 digit angka',
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

        $user = User::where('phone_number', $request->phone_number)->first();

        if (!$user) {
            return response()->json([
                'status' => 'error',
                'code' => 404,
                'message' => 'Nomor Handphone belum terdaftar',
                'data' => null,
            ], 404);
        }

        // if ($user->otp !== $request->otp || Carbon::now()->gt($user->otp_expires_at)) {
        if ($otp_hardcode !== $request->otp) {
            return response()->json([
                'status' => 'error',
                'code' => 401,
                'message' => 'Kode OTP salah',
                'data' => null,
            ], 401);
        }

        return response()->json([
            'status' => 'success',
            'code' => 200,
            'message' => 'OTP berhasil diverifikasi',
            'data' => [
                'id' => (string) $user->id,
                'name' => (string) $user->name,
                'phone_number' => (string) $user->phone_number,
            ]
        ]);

        // if ($user->is_verified) {
        //     return response()->json([
        //         'status' => 'success',
        //         'code' => 200,
        //         'message' => 'User sudah terverifikasi',
        //     ]);
        // }

        // OTP cocok dan masih aktif
        // $user->update([
        //     'is_verified' => true,
        //     'otp' => null,
        //     'otp_expires_at' => null,
        // ]);

        // return response()->json([
        //     'status' => 'success',
        //     'code' => 200,
        //     'message' => 'OTP berhasil diverifikasi',
        //     'data' => [
        //         'id' => (string) $user->id,
        //         'name' => (string) $user->name,
        //         'phone_number' => (string) $user->phone_number,
        //     ]
        // ]);
    }

    public function resendOtp(Request $request)
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
            $errorMessages = implode(' ', $validator->errors()->all());

            return response()->json([
                'status' => 'error',
                'code' => 422,
                'message' => $errorMessages,
                'data' => null,
            ], 422);
        }

        $user = User::where('phone_number', $request->phone_number)->first();

        if (!$user) {
            return response()->json([
                'status' => 'error',
                'code' => 404,
                'message' => 'Nomor handphone tidak ditemukan.',
                'data' => null,
            ], 404);
        }

        $otp = rand(1000, 9999);
        $otpExpiresAt = now()->addMinutes(5);

        // $user->update([
        //     'otp' => $otp,
        //     'otp_expires_at' => $otpExpiresAt,
        // ]);

        return response()->json([
            'status' => 'success',
            'code' => 200,
            'message' => 'Kode OTP baru telah dikirim',
            'data' => [
                'expired_in' => now()->diffInSeconds($otpExpiresAt),
                'otp' => (string) $otp,
            ]
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
            'otp' => 'required|digits:4',
            'new_password' => 'required|min:8|confirmed',
        ], [
            'phone_number.required' => 'Nomor handphone wajib diisi',
            'phone_number.string' => 'Nomor handphone harus berupa teks',
            'phone_number.regex' => 'Format nomor handphone tidak valid',
            'otp.required' => 'Kode OTP wajib diisi',
            'otp.digits' => 'Kode OTP harus terdiri dari 4 digit angka',
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

        // $user = User::where('phone_number', $request->phone_number)
        //     ->where('otp', $request->otp)
        //     ->where('otp_expires_at', '>=', now())
        //     ->first();
        $user = User::where('phone_number', $request->phone_number)->first();

        if (!$user) {
            return response()->json([
                'status' => 'error',
                'code' => 401,
                'message' => 'OTP tidak valid atau sudah kedaluwarsa.',
                'data' => null,
            ], 401);
        }

        // Update password
        $user->update([
            'password' => Hash::make($request->new_password),
            // 'otp' => null,
            // 'otp_expires_at' => null,
        ]);

        return response()->json([
            'status' => 'success',
            'code' => 200,
            'message' => 'Password berhasil diubah.',
            'data' => [
                'id' => $user->id,
                'updated_at' => Carbon::now()->toISOString(),
            ],
        ]);
    }
}
