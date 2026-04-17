<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class UserPublic extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    protected $fillable = [
        'name',
        'phone_number',
        'email',
        'password',
        'fcm_token',
        'status_akun',
        'otp',
        'otp_expires_at',
        'last_otp_sent_at',
        'remember_token',
        'password_reset_token',
        'password_reset_expires_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'otp',
    ];

    protected $casts = [
        'otp_expires_at' => 'datetime',
        'updated_at' => 'datetime',
        'last_otp_sent_at' => 'datetime',
        'password_reset_expires_at' => 'datetime',
    ];

    // -------------------------------------------------------
    // Relasi
    // -------------------------------------------------------

    /**
     * Semua metode login yang dimiliki user ini.
     */
    public function identities(): HasMany
    {
        return $this->hasMany(UserIdentity::class, 'user_public_id');
    }

    /**
     * Request ganti nomor HP yang sedang aktif.
     */
    public function phoneChangeRequest(): HasOne
    {
        return $this->hasOne(PhoneChangeRequest::class, 'user_public_id');
    }

    public function profile()
    {
        return $this->hasOne(UserPublicProfile::class, 'user_public_id');
    }

    public function nomorRangkas()
    {
        return $this->hasMany(NomorRangka::class, 'user_public_id');
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class, 'user_public_id');
    }

    // -------------------------------------------------------
    // Helper Methods
    // -------------------------------------------------------

    /**
     * Cek apakah user punya metode login tertentu.
     * Contoh: $user->hasIdentity('google')
     */
    public function hasIdentity(string $provider): bool
    {
        return $this->identities()->where('provider', $provider)->exists();
    }

    /**
     * Cek apakah OTP di tabel users masih berlaku.
     * (Dipakai untuk verifikasi registrasi)
     */
    public function isOtpValid(): bool
    {
        return $this->otp !== null
            && $this->otp_expires_at !== null
            && $this->otp_expires_at->isFuture();
    }
}