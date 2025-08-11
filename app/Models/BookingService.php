<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingService extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'motor_id',
        'booking_id',
        'dealer_id',
        'tanggal',
        'jam',
    ];

    public function user()
    {
        return $this->belongsTo(UserPublic::class, 'user_id');
    }

    public function motor()
    {
        return $this->belongsTo(NomorRangka::class, 'motor_id');
    }
}
