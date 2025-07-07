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
        // Validasi input
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'max:50', 'regex:/^[a-zA-Z\s]+$/'],
            'phone_number' => [
                'required',
                'numeric',
                'regex:/^08[1-9][0-9]{6,10}$/',
                'unique:users,phone_number', // Tambahkan aturan unik di sini jika diperlukan
            ],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'password_confirmation' => 'required|string|min:8',
        ], [
            'name.required' => 'Kolom nama wajib diisi.',
            'name.string' => 'Kolom nama harus berupa teks.',
            'name.max' => 'Kolom nama tidak boleh lebih dari :max karakter.',
            'name.regex' => 'Wajib menggunakan huruf.',
            'phone_number.required' => 'Kolom nomor handphone wajib diisi.',
            'phone_number.numeric' => 'Kolom nomor handphone harus berupa angka.',
            'phone_number.regex' => 'Format nomor handphone tidak valid. Pastikan diawali dengan 08 dan maksimal 13 digit',
            'phone_number.unique' => 'Nomor handphone sudah digunakan.',
            'password.required' => 'Kolom password wajib diisi.',
            'password.string' => 'Kolom password harus berupa teks.',
            'password.min' => 'Password minimal harus :min karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        if ($validator->fails()) {
            $errorMessages = implode(' ', $validator->errors()->all());

            return response()->json([
                'status' => 'error',
                'code' => 422,
                'message' => 'Validasi gagal. ' . $errorMessages,
                'data' => null,
            ], 422);
        }

        // Buat OTP hardcoded untuk development
        // $otp = rand(1000, 9999);
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
                'otp' => (string) 1111,
                // 'otp_expired_in' => $otpExpiresAt->diffInSeconds(Carbon::now()),
            ]
        ]);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone_number' => 'required|string',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            $errorMessages = implode(' ', $validator->errors()->all());

            return response()->json([
                'status' => 'error',
                'code' => 422,
                'message' => 'Validasi gagal. ' . $errorMessages,
                'data' => null,
            ], 422);
        }

        $user = User::where('phone_number', $request->phone_number)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'status' => 'error',
                'code' => 401,
                'message' => 'Nomor telepon atau password salah',
                'data' => null
            ], 401);
        }

        // Generate token
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
            'phone_number' => 'required|numeric',
            'otp' => 'required|digits:4',
        ], [
            'phone_number.required' => 'Nomor handphone wajib diisi.',
            'phone_number.numeric' => 'Nomor handphone hanya boleh diisi dengan angka.',
            'otp.required' => 'Kode OTP wajib diisi.',
            'otp.digits' => 'Kode OTP harus terdiri dari 4 digit angka.',
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

        // $phone_number = $user->phone_number;
        
        // if ($phone_number != $request->phone_number) {
        //     return response()->json([
        //         'status' => 'error',
        //         'code' => 404,
        //         'message' => 'Nomor tidak ditemukan',
        //     ], 404);
        // }

        // if ($user->otp !== $request->otp || Carbon::now()->gt($user->otp_expires_at)) {
        if ($otp_hardcode !== $request->otp) {
            return response()->json([
                'status' => 'error',
                'code' => 401,
                'message' => 'Kode OTP salah atau sudah kadaluarsa',
                'data' => [
                    'id' => (string) $user->id,
                    'name' => (string) $user->name,
                    'phone_number' => (string) $user->phone_number,
                ]
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

        // if ($user->otp !== $request->otp || Carbon::now()->gt($user->otp_expires_at)) {
        //     return response()->json([
        //         'status' => 'error',
        //         'code' => 401,
        //         'message' => 'Kode OTP salah atau sudah kadaluarsa',
        //     ], 401);
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
        //         'user_id' => $user->id,
        //         'nama' => $user->nama,
        //         'no_handphone' => $user->phone,
        //     ]
        // ]);
    }

    public function resendOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone_number' => 'required|numeric',
        ], [
            'phone_number.required' => 'Nomor handphone wajib diisi.',
            'phone_number.numeric' => 'Nomor handphone hanya boleh diisi dengan angka.',
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
}
