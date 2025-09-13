<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
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
        'google_id',
        'facebook_id',
        'status_akun',
        'login_method',
        'otp',
        'otp_expires_at',
        'email_verified_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'otp_expires_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function profile()
    {
        return $this->hasOne(UserPublicProfile::class, 'user_public_id');
    }

    public function nomorRangkas()
    {
        return $this->hasMany(NomorRangka::class, 'user_public_id');
    }

    /**
     * Relasi ke notifikasi
     */
    public function notifications()
    {
        return $this->hasMany(Notification::class, 'user_public_id');
    }
}
