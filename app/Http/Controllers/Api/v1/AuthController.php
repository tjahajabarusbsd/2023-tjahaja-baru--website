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
            'name' => 'required|string',
            // 'phone_number' => 'required|string|unique:users,phone_number',
            'phone_number' => 'required|string',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'code' => 422,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors(),
            ], 422);
        }

        // Buat OTP hardcoded untuk development
        $otp = rand(1000, 9999);
        $otpExpiresAt = Carbon::now()->addMinutes(5);

        // Simpan user ke database
        // $user = User::create([
        //     'name' => $request->name,
        //     'phone_number' => $request->phone_number,
        //     'password' => Hash::make($request->password),
        //     'otp' => $otp,
        //     'otp_expires_at' => $otpExpiresAt,
        // ]);

        return response()->json([
            'status' => 'success',
            'code' => 200,
            'message' => 'Register berhasil',
            'data' => [
                'id' => 1,
                'name' => $request->name,
                'phone_number' => $request->phone_number,
                'created_at' => Carbon::now()->toISOString(),
                'updated_at' => Carbon::now()->toISOString(),
                'otp' => $otp,
                'otp_expired_in' => $otpExpiresAt->diffInSeconds(Carbon::now()),
            ]
        ]);
    }

    public function verifyOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone_number' => 'required|string',
            'otp' => 'required|digits:4',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'code' => 422,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors(),
            ], 422);
        }

        // $user = User::where('phone', $request->phone)->first();
        $user = "081234567890"; // Hardcoded user for development
        
        if ($user != $request->phone_number) {
            return response()->json([
                'status' => 'error',
                'code' => 404,
                'message' => 'Nomor tidak ditemukan',
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'code' => 200,
            'message' => 'OTP berhasil diverifikasi',
            'data' => [
                'user_id' => 1,
                'nama' => "Fadhil",
                'no_handphone' => $user,
            ]
        ]);

        // if ($user->is_verified) {
        //     return response()->json([
        //         'status' => 'success',
        //         'code' => 200,
        //         'message' => 'User sudah terverifikasi',
        //     ]);
        // }

        if ($user->otp !== $request->otp || Carbon::now()->gt($user->otp_expires_at)) {
            return response()->json([
                'status' => 'error',
                'code' => 401,
                'message' => 'Kode OTP salah atau sudah kadaluarsa',
            ], 401);
        }

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
}
