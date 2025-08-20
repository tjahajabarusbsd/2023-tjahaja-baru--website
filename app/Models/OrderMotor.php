<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderMotor extends Model
{
    use CrudTrait;
    use HasFactory;

    protected $fillable = [
        'order_id',
        'user_public_id',
        'model',
        'warna',
        'tipe_pembayaran',
        'status'
    ];

    /**
     * Get the user associated with the order.
     */
    public function user()
    {
        return $this->belongsTo(UserPublic::class, 'user_public_id');
    }
}
