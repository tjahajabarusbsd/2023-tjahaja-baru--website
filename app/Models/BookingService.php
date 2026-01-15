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
        'menu_layanan',
        'permintaan_khusus',
        'tanggal',
        'jam',
        'status',
        'points_awarded_at',
        'service_schedule_id',
        'serialized_product_id',
        'external_status',
    ];

    protected $casts = [
        'service_schedule_id' => 'string',
        'serialized_product_id' => 'string',
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
