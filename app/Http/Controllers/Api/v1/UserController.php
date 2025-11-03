<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\EditProfileRequest;
use App\Models\UserPublic;
use App\Services\PhoneNumberService;
use App\Services\OtpService;
use App\Services\LoyaltyService;
use Illuminate\Http\Request;
use App\Helpers\ApiResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use App\Http\Controllers\WhatsAppController;

class UserController extends Controller
{
    public function getUser(Request $request)
    {
        $user = Auth::user();

        return ApiResponse::success('Data user berhasil diambil', [
            'id' => (string) $user->id,
            'name' => (string) $user->name,
            'points' => (int) ($user->profile->total_points ?? 0),
            'life_time_points' => (int) ($user->profile->lifetime_points ?? 0),
        ]);
    }

    public function getAccount(Request $request)
    {
        $user = Auth::user();
        $profile = $user->profile;

        $lifetimePoints = (int) ($profile->lifetime_points ?? 0);
        $membership = LoyaltyService::getTierByPoints($lifetimePoints);

        // Pastikan reward tier hanya diberikan sekali
        $alreadyGranted = \App\Models\RewardClaim::where('user_profile_id', $profile->id)
            ->where('source', 'loyalty_' . strtolower($membership['tier']))
            ->exists();

        if (!$alreadyGranted) {
            LoyaltyService::grantTierBenefits($profile, $membership['tier']);
        }

        return ApiResponse::success('Data akun berhasil dimuat', [
            'user_id' => (int) $user->id,
            'name' => (string) $user->name,
            // 'email' => (string) $user->email,
            // 'no_handphone' => (string) $user->phone_number,
            'jenis_kelamin' => $profile->jenis_kelamin ?? '',
            'tanggal_lahir' => $profile->tgl_lahir ?? '',
            'foto_profil' => asset($profile->foto_profil) ?? '',
            'membership' => $membership,
        ]);
    }

    public function editProfile(EditProfileRequest $request)
    {
        $user = Auth::user();

        DB::beginTransaction();
        try {
            // Update tabel user_publics
            $user->update([
                'name' => $request->full_name,
                // 'phone_number' => $request->phone ?? $user->phone_number,
                // 'email' => $request->email ?? $user->email,
            ]);

            // Ambil profile relasi
            $profile = $user->profile;

            // Update field profile
            $profile->jenis_kelamin = $request->gender ?? $profile->jenis_kelamin;
            if ($request->filled('birth_date')) {
                $profile->tgl_lahir = Carbon::createFromFormat('d/m/Y', $request->birth_date)
                    ->format('Y-m-d');
            }

            // Update foto profil (hanya kalau ada upload)
            if ($request->hasFile('photo_filename')) {
                $fotoProfil64 = 'data:' . $request->file('photo_filename')->getMimeType()
                    . ';base64,' . base64_encode(file_get_contents($request->file('photo_filename')));

                // ini akan memicu setFotoProfilAttribute() di model
                $profile->foto_profil = $fotoProfil64;
            }

            $profile->save();

            DB::commit();

            return ApiResponse::success('Profil berhasil diperbarui', [
                'full_name' => (string) $user->name,
                // 'phone' => (string) $user->phone_number,
                // 'email' => (string) $user->email,
                'gender' => (string) $profile->jenis_kelamin,
                'birth_date' => $profile->tgl_lahir
                    ? Carbon::parse($profile->tgl_lahir)->format('d/m/Y')
                    : null, // balikin ke format Flutter
                'photo_filename' => (string) $profile->foto_profil,
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return ApiResponse::error('Gagal memperbarui profil: ' . $e->getMessage(), 500);
        }
    }

    public function changePassword(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'old_password' => 'required|string',
                'new_password' => 'required|string|min:8|confirmed',
            ], [
                'old_password.required' => 'Password saat ini wajib diisi',
                'old_password.string' => 'Password saat ini harus berupa teks',
                'new_password.required' => 'Password baru wajib diisi',
                'new_password.string' => 'Password baru harus berupa teks',
                'new_password.min' => 'Password minimal 8 karakter',
                'new_password.confirmed' => 'Konfirmasi password tidak cocok.',
            ]);

            if ($validator->fails()) {
                return ApiResponse::error($validator->errors()->first(), 400);
            }

            $user = Auth::user();
            if (!$user) {
                return ApiResponse::error('User tidak ditemukan atau belum login', 401);
            }

            if (!Hash::check($request->old_password, $user->password)) {
                return ApiResponse::error('Password lama tidak sesuai', 400);
            }

            $user->password = Hash::make($request->new_password);
            $user->save();

            return ApiResponse::success('Password berhasil diperbarui');
        } catch (\Throwable $e) {
            return ApiResponse::error('Terjadi kesalahan server: ' . $e->getMessage(), 500);
        }
    }

    public function requestChangeNomorHp(Request $request)
    {
        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'new_phone_number' => [
                'required',
                'string',
                'regex:/^(\+62|62|0)8[1-9][0-9]{7,10}$/',
            ],
        ], [
            'new_phone_number.required' => 'Nomor handphone baru wajib diisi',
            'new_phone_number.string' => 'Nomor handphone baru harus berupa teks',
            'new_phone_number.regex' => 'Format nomor handphone tidak valid',
        ]);

        if ($validator->fails()) {
            return ApiResponse::error($validator->errors()->first(), 400);
        }

        $normalizedPhone = PhoneNumberService::normalize($request->new_phone_number);

        if ($normalizedPhone === $user->phone_number) {
            return ApiResponse::error('Nomor HP baru sama dengan nomor yang terdaftar', 400);
        }

        $exists = UserPublic::where('phone_number', $normalizedPhone)->where('id', '!=', $user->id)->exists();
        if ($exists) {
            return ApiResponse::error('Nomor handphone sudah digunakan oleh pengguna lain', 409);
        }

        // Generate OTP
        $otp = 1111;

        // Kirim OTP via WhatsApp
        // Cek response dari WhatsApp API

        $user->update([
            'otp' => $otp,
            'temp_new_phone_number' => $normalizedPhone,
        ]);

        return ApiResponse::success('Kode OTP telah dikirim ke WhatsApp Anda', [
            'id' => $user->id,
            'new_phone_number' => $normalizedPhone,
            'updated_at' => Carbon::now()->toISOString(),
        ]);

    }

    public function verifyChangeNomorHp(Request $request)
    {
        $user = Auth::user();

        if ($user->otp != $request->otp) {
            return ApiResponse::error('Kode OTP tidak valid', 400);
        }

        $user->update([
            'phone_number' => $user->temp_new_phone_number,
            'temp_new_phone_number' => null,
            'otp' => null,
        ]);

        return ApiResponse::success('Nomor handphone Anda berhasil diganti', [
            'id' => $user->id,
            'name' => (string) $user->name,
            'phone_number' => (string) $user->phone_number,
        ]);
    }


    private function getMembershipTier(int $lifetimePoints): array
    {
        $tiers = config('loyalty.tiers');

        $currentTier = $tiers[0]; // default Basic
        foreach (array_reverse($tiers) as $tier) {
            if ($lifetimePoints >= $tier['min_points']) {
                $currentTier = $tier;
                break;
            }
        }

        return [
            'tier' => $currentTier['name'],
            'points' => $lifetimePoints,
        ];
    }
}
