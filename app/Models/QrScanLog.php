<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QrScanLog extends Model
{
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
}
