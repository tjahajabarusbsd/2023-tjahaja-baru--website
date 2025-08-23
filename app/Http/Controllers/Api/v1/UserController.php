<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\EditProfileRequest;
use Illuminate\Http\Request;
use App\Helpers\ApiResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function getUser(Request $request)
    {
        $user = Auth::user();

        return ApiResponse::success('Data user berhasil diambil', [
            'id' => (string) $user->id,
            'name' => (string) $user->name,
            'points' => (int) ($user->profile->total_points ?? 0),
        ]);
    }

    public function getAccount(Request $request)
    {
        $user = Auth::user();

        $points = (int) ($user->profile->total_points ?? 0);
        $membership = $this->getMembershipTier($points);

        return ApiResponse::success('Data akun berhasil dimuat', [
            'user_id' => (int) $user->id,
            'name' => (string) $user->name,
            'email' => (string) $user->email,
            'no_handphone' => (string) $user->phone_number,
            'jenis_kelamin' => $user->profile->jenis_kelamin ?? '',
            'tanggal_lahir' => $user->profile->tgl_lahir ?? '',
            'foto_profil' => $user->profile->foto_profil ?? '',
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
                'phone_number' => $request->phone ?? $user->phone_number,
                'email' => $request->email ?? $user->email,
            ]);

            // Ambil profile relasi
            $profile = $user->profile;

            // Update field profile
            $profile->jenis_kelamin = $request->gender ?? $profile->jenis_kelamin;
            $profile->tgl_lahir = $request->birth_date ?? $profile->tgl_lahir;

            // Update foto profil (hanya kalau ada upload)
            if ($request->hasFile('photo_filename')) {
                $fotoProfil64 = 'data:' . $request->file('foto_profil')->getMimeType()
                    . ';base64,' . base64_encode(file_get_contents($request->file('photo_filename')));

                // ini akan memicu setFotoProfilAttribute() di model
                $profile->foto_profil = $fotoProfil64;
            }

            $profile->save();

            DB::commit();

            return ApiResponse::success('Profil berhasil diperbarui', [
                'full_name' => (string) $user->name,
                'phone' => (string) $user->phone_number,
                'email' => (string) $user->email,
                'gender' => (string) $profile->jenis_kelamin,
                'birth_date' => (string) $profile->tgl_lahir,
                'photo_filename' => (string) $profile->foto_profil,
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return ApiResponse::error('Gagal memperbarui profil: ' . $e->getMessage(), 500);
        }
    }

    private function getMembershipTier(int $points): array
    {
        $tiers = [
            ['name' => 'Platinum', 'min_points' => 100000],
            ['name' => 'Gold', 'min_points' => 50000],
            ['name' => 'Silver', 'min_points' => 1000],
            ['name' => 'Basic', 'min_points' => 0],
        ];

        foreach ($tiers as $tier) {
            if ($points >= $tier['min_points']) {
                return [
                    'tier' => $tier['name'],
                    'points' => $points,
                ];
            }
        }

        return [
            'tier' => 'Unknown',
            'points' => $points,
        ];
    }
}
