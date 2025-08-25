<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reward extends Model
{
    use CrudTrait;
    use HasFactory;
    protected $fillable = [
        'merchant_id',
        'title',
        'image',
        'point',
        'quantity',
        'masa_berlaku_mulai',
        'masa_berlaku_selesai',
        'aktif',
        'deskripsi',
        'terms_conditions',
    ];

    public function merchant()
    {
        return $this->belongsTo(Merchant::class);
    }
}
