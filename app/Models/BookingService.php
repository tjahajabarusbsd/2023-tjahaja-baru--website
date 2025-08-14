<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingService extends Model
{
    use CrudTrait;
    use HasFactory;

    protected $fillable = [
        'user_id',
        'motor_id',
        'booking_id',
        'dealer_id',
        'tanggal',
        'jam',
        'status',
    ];

    public function dealer()
    {
        return $this->belongsTo(Dealer::class, 'dealer_id');
    }

    public function user()
    {
        return $this->belongsTo(UserPublic::class, 'user_id');
    }

    public function motor()
    {
        return $this->belongsTo(NomorRangka::class, 'motor_id');
    }
}
