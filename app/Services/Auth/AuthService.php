<?php

namespace App\Services\Auth;

use App\Http\Requests\RegisterRequest;
use App\Models\UserIdentity;
use App\Models\UserPublic;
use App\Services\OtpService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    public function __construct(private OtpService $otpService)
    {
    }

    public function findUserByPhone(string $phone): ?UserPublic
    {
        return UserPublic::where('phone_number', $phone)->first();
    }

    public function getOtpCooldownSeconds(?UserPublic $user): ?int
    {
        if (!$user || !$user->last_otp_sent_at || $user->last_otp_sent_at <= now()->subMinute()) {
            return null;
        }

        return now()->diffInSeconds($user->last_otp_sent_at->copy()->addMinute());
    }

    public function register(RegisterRequest $request, string $phone, ?UserPublic $existingUser): UserPublic
    {
        return DB::transaction(function () use ($existingUser, $phone, $request) {
            $user = $this->upsertPendingUser($existingUser, $request, $phone);
            $this->otpService->sendOtp($user, 'register', $phone);

            return $user->fresh();
        });
    }

    public function verifyRegistrationOtp(UserPublic $user): UserPublic
    {
        return DB::transaction(function () use ($user) {
            $this->activateUser($user);

            return $user->fresh();
        });
    }

    public function login(UserPublic $user, string $tokenName = 'auth_mobile_token'): string
    {
        $this->pruneOldestTokenIfNeeded($user);

        return (string) $user->createToken($tokenName)->plainTextToken;
    }

    public function logout(UserPublic $user): void
    {
        $user->tokens()->delete();
    }

    public function updateFcmToken(?UserPublic $user, string $fcmToken): void
    {
        if (!$user) {
            throw new ModelNotFoundException('Authenticated user not found.');
        }

        $user->forceFill([
            'fcm_token' => $fcmToken,
        ])->save();
    }

    public function buildUserPayload(UserPublic $user, bool $includeTimestamps = false, array $extra = []): array
    {
        $payload = [
            'id' => (string) $user->id,
            'name' => (string) $user->name,
            'phone_number' => (string) $user->phone_number,
        ];

        if ($user->status_akun !== null) {
            $payload['status_akun'] = $user->status_akun;
        }

        if ($includeTimestamps) {
            $payload['created_at'] = $user->created_at?->toISOString();
            $payload['updated_at'] = $user->updated_at?->toISOString();
        }

        return $payload + $extra;
    }

    private function upsertPendingUser(?UserPublic $existingUser, RegisterRequest $request, string $phone): UserPublic
    {
        $payload = [
            'name' => $request->name,
            'password' => Hash::make($request->password),
            'status_akun' => 'pending',
        ];

        if ($existingUser) {
            $existingUser->update($payload);

            return $existingUser;
        }

        $user = UserPublic::create($payload + [
            'phone_number' => $phone,
        ]);

        UserIdentity::create([
            'user_public_id' => $user->id,
            'provider' => 'phone',
            'provider_id' => $phone,
        ]);

        return $user;
    }

    private function activateUser(UserPublic $user): void
    {
        $user->update([
            'status_akun' => 'aktif',
            'otp' => null,
            'otp_expires_at' => null,
            'last_otp_sent_at' => null,
        ]);

        if (!$user->profile()->exists()) {
            $user->profile()->create([
                'tgl_lahir' => null,
                'alamat' => null,
                'jenis_kelamin' => null,
                'total_points' => 0,
            ]);
        }
    }

    private function pruneOldestTokenIfNeeded(UserPublic $user): void
    {
        $tokens = $user->tokens()->oldest()->get();

        if ($tokens->count() >= 3) {
            $tokens->first()?->delete();
        }
    }
}
