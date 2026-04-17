<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class UserIdentity extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_public_id',
        'provider',
        'provider_id',
    ];

    /**
     * Relasi ke user pemilik identity ini.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(UserPublic::class, 'user_public_id');
    }
}
