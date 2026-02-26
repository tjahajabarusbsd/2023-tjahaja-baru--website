<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\app\Models\Traits\CrudTrait;

class QrScanLog extends Model
{
    use CrudTrait;
    use HasFactory;

    protected $table = 'qr_scan_logs';

    protected $fillable = [
        'scan_code',
        'user_public_id',
        'qrcode_id',
        'usage_count',
        'max_usage',
        'scanned_at',
    ];

    protected $casts = [
        'scanned_at' => 'datetime',
        'usage_count' => 'integer',
        'max_usage' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(UserPublic::class, 'user_public_id');
    }

    public function qrcode()
    {
        return $this->belongsTo(Qrcode::class, 'qrcode_id');
    }

    public function getMerchantTitleAttribute()
    {
        return $this->qrcode && $this->qrcode->merchant ? $this->qrcode->merchant->title : 'N/A';
    }

    protected static function booted()
    {
        static::addGlobalScope('merchant', function ($builder) {

            if (backpack_auth()->check()) {

                $user = backpack_user();

                if ($user->hasRole('merchant_admin')) {

                    $builder->whereHas('qrcode', function ($q) use ($user) {
                        $q->where('merchant_id', $user->merchant_id);
                    });

                }
            }

        });
    }
}
