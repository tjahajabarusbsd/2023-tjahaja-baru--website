<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VoucherScanLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'reward_claim_id',
        'scanned_by_merchant_id',
        'result_status',
        'scan_time',
    ];

    protected $casts = [
        'scan_time' => 'datetime',
    ];

    public function rewardClaim()
    {
        return $this->belongsTo(RewardClaim::class);
    }

    public function merchant()
    {
        return $this->belongsTo(Merchant::class, 'scanned_by_merchant_id');
    }
}
