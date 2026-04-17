<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class PhoneChangeRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_public_id',
        'new_phone_number',
        'otp',
        'otp_expires_at',
        'last_otp_sent_at',
        'status',
    ];

    protected $casts = [
        'otp_expires_at' => 'datetime',
        'last_otp_sent_at' => 'datetime',
    ];

    /**
     * Relasi ke user pemilik request ini.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(UserPublic::class, 'user_public_id');
    }

    /**
     * Cek apakah OTP masih berlaku.
     */
    public function isOtpValid(): bool
    {
        return $this->otp !== null
            && $this->otp_expires_at !== null
            && $this->otp_expires_at->isFuture();
    }

    /**
     * Cek apakah request ini sudah expired.
     */
    public function isExpired(): bool
    {
        return $this->otp_expires_at !== null
            && $this->otp_expires_at->isPast();
    }
}
