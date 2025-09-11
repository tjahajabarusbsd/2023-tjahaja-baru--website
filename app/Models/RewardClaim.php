<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RewardClaim extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_profile_id',
        'reward_id',
        'status',
        'point_used',
        'kode_voucher',
        'shipping_address',
        'source',
        'expires_at',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
    ];

    // Accessor: status_label
    public function getStatusLabelAttribute()
    {
        if ($this->status === 'aktif' && $this->expires_at && $this->expires_at->isPast()) {
            return 'kadaluarsa';
        }

        return $this->status;
    }

    public function reward()
    {
        return $this->belongsTo(Reward::class);
    }

    public function userProfile()
    {
        return $this->belongsTo(UserPublicProfile::class);
    }
}
