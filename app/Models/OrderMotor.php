<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderMotor extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'user_public_id',
        'model',
        'warna',
        'tipe_pembayaran',
        'status'
    ];
}
