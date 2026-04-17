<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\EditProfileRequest;
use App\Models\UserIdentity;
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
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Illuminate\Validation\Rules\Password;
use Exception;

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
        // $alreadyGranted = \App\Models\RewardClaim::where('user_profile_id', $profile->id)
        //     ->where('source', 'loyalty_' . strtolower($membership['tier']))
        //     ->exists();

        // if (!$alreadyGranted) {
        //     LoyaltyService::grantTierBenefits($profile, $membership['tier']);
        // }

        $phoneNumber = $user->phone_number;
        // change phone number format from 62 to 0
        if (substr($phoneNumber, 0, 2) === '62') {
            $phoneNumber = '0' . substr($phoneNumber, 2);
        }

        return ApiResponse::success('Data akun berhasil dimuat', [
            'user_id' => (int) $user->id,
            'name' => (string) $user->name,
            'email' => (string) $user->email,
            'no_handphone' => (string) $phoneNumber,
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
            $user->update([
                'name' => $request->full_name,
            ]);

            // Ambil profile relasi
            $profile = $user->profile;

            // Update field profile
            if ($request->filled('gender')) {
                $profile->jenis_kelamin = $request->gender;
            }

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

            // if ($request->hasFile('photo_filename')) {
            //     $file = $request->file('photo_filename');
            //     if ($file->isValid()) {
            //         // Buat nama file unik
            //         $fileName = 'profile_' . $user->id . '_' . time() . '.' . $file->getClientOriginalExtension();

            //         // Simpan file ke storage disk 'public'
            //         $path = $file->storeAs('profile_photos', $fileName, 'public');

            //         // Hapus foto lama jika ada
            //         if ($profile->foto_profil) {
            //             Storage::disk('public')->delete($profile->foto_profil);
            //         }

            //         // Simpan path file ke database
            //         $profile->foto_profil = $path;
            //     }
            // }

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
                // 'photo_filename' => $profile->foto_profil ? asset('storage/' . $profile->foto_profil) : null,
            ]);

        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Gagal memperbarui profil untuk user ID: ' . $user->id);
            Log::error($e);
            return ApiResponse::error('Terjadi kesalahan pada server. Gagal memperbarui profil.', 500);
        }
    }

    public function changePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'old_password' => 'required|string',
            'new_password' => ['required', 'string', 'confirmed', Password::min(8)->mixedCase()->numbers()->symbols()],
        ], [
            'old_password.required' => 'Password saat ini wajib diisi.',
            'new_password.required' => 'Password baru wajib diisi.',
            'new_password.confirmed' => 'Konfirmasi password tidak cocok.',
            'new_password.min' => 'Password minimal 8 karakter.',
            'new_password.mixed_case' => 'Password harus mengandung huruf besar dan kecil.',
            'new_password.numbers' => 'Password harus mengandung setidaknya satu angka.',
            'new_password.symbols' => 'Password harus mengandung setidaknya satu simbol.',
        ]);

        if ($validator->fails()) {
            return ApiResponse::error($validator->errors()->first(), 422);
        }

        try {
            $user = Auth::user();

            if (!$user || !Hash::check($request->old_password, $user->password)) {
                return ApiResponse::error('Password lama yang Anda masukkan tidak cocok. Silakan periksa kembali.', 401);
            }

            $user->password = Hash::make($request->new_password);
            $user->save();

            Log::info('Auth User dengan ID ' . $user->id . ' berhasil mengganti password.');

        } catch (\Throwable $e) {
            Log::error('Gagal mengganti password untuk Auth user ID: ' . ($user->id ?? 'unknown'));
            Log::error($e);

            return ApiResponse::error('Terjadi kesalahan pada server. Silakan coba lagi nanti.', 500);
        }

        return ApiResponse::success('Password berhasil diperbarui', [
            'id' => (string) $user->id,
            'updated_at' => $user->updated_at->toISOString(),
        ]);
    }

    public function requestChangeNomorHp(Request $request, OtpService $otpService)
    {
        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'new_phone_number' => [
                'required',
                'string',
                'regex:/^(\+62|62|0)8[1-9][0-9]{7,10}$/',
            ],
        ], [
            'new_phone_number.required' => 'Nomor HP baru wajib diisi',
            'new_phone_number.string' => 'Nomor HP baru harus berupa teks',
            'new_phone_number.regex' => 'Format nomor HP tidak valid',
        ]);

        if ($validator->fails()) {
            return ApiResponse::error($validator->errors()->first(), 422);
        }

        $normalizedPhone = PhoneNumberService::normalize($request->new_phone_number);

        if ($normalizedPhone === $user->phone_number) {
            return ApiResponse::error('Nomor HP baru sama dengan nomor saat ini', 400);
        }

        $phoneExists = UserPublic::where('phone_number', $normalizedPhone)->where('id', '!=', $user->id)->exists();
        if ($phoneExists) {
            return ApiResponse::error('Nomor HP baru sudah digunakan.', 400);
        }

        try {
            $otpService->sendOtp($user, 'change_phone', $normalizedPhone);

            Log::info('OTP untuk perubahan nomor HP berhasil dikirim', [
                'user_id' => $user->id,
                'new_phone_number' => $normalizedPhone,
            ]);
        } catch (Exception $e) {
            Log::error('Error during phone change request for user ' . $user->id . ': ' . $e->getMessage());
            return ApiResponse::error('Terjadi kesalahan internal pada server. Silakan coba lagi.', 500);
        }

        return ApiResponse::success('Kode OTP telah dikirim ke WhatsApp Anda', [
            'id' => $user->id,
            'new_phone_number' => $normalizedPhone,
        ]);
    }

    public function verifyChangeNomorHp(Request $request)
    {
        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'phone_number' => [
                'required',
                'string',
                'regex:/^(\+62|62|0)8[1-9][0-9]{7,10}$/',
            ],
            'otp' => 'required|string',
        ], [
            'phone_number.required' => 'Nomor handphone wajib diisi',
            'phone_number.string' => 'Nomor handphone harus berupa teks',
            'phone_number.regex' => 'Format nomor handphone tidak valid',
            'otp.required' => 'Kode OTP wajib diisi',
            'otp.string' => 'Kode OTP harus berupa teks',
        ]);

        if ($validator->fails()) {
            return ApiResponse::error($validator->errors()->first(), 422);
        }

        $existingRequest = $user->phoneChangeRequest;

        if (!$existingRequest) {
            return ApiResponse::error('Tidak ada proses perubahan nomor HP.', 400);
        }

        if ($existingRequest->new_phone_number !== PhoneNumberService::normalize($request->phone_number)) {
            return ApiResponse::error('Nomor tidak sesuai dengan permintaan perubahan.', 400);
        }

        if (!$existingRequest->otp || !$existingRequest->otp_expires_at) {
            return ApiResponse::error('Kode OTP sudah tidak berlaku.', 400);
        }

        if ($existingRequest->otp_expires_at->isPast()) {
            $existingRequest->update([
                'otp' => null,
                'otp_expires_at' => null,
                'last_otp_sent_at' => null,
            ]);

            return ApiResponse::error('Kode OTP telah kadaluarsa.', 400);
        }

        if (!Hash::check($request->otp, $existingRequest->otp)) {
            Log::warning('OTP ganti nomor HP salah untuk user ' . $user->id);
            return ApiResponse::error('Kode OTP tidak valid.', 400);
        }

        try {
            DB::beginTransaction();

            $user->update([
                'phone_number' => $existingRequest->new_phone_number,
            ]);

            $existingRequest->update([
                'otp' => null,
                'otp_expires_at' => null,
                'last_otp_sent_at' => null,
                'status' => 'verified',
            ]);

            $user->identities()
                ->where('provider', 'phone')
                ->update([
                    'provider_id' => $existingRequest->new_phone_number
                ]);

            DB::commit();

            Log::info('Nomor HP berhasil diganti untuk user ' . $user->id);
        } catch (Exception $e) {
            DB::rollBack();

            Log::error('Gagal update nomor HP', [
                'user_id' => $user->id,
                'error' => $e->getMessage(),
            ]);

            return ApiResponse::error('Gagal menyimpan perubahan.', 500);
        }

        return ApiResponse::success('Nomor HP berhasil diganti', [
            'id' => (string) $user->id,
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
