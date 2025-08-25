<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Merchant extends Model
{
    use CrudTrait;
    use HasFactory;

    protected $fillable = [
        'title',
        'image',
        'deskripsi',
        'lokasi',
        'aktif',
    ];

    public function rewards()
    {
        return $this->hasMany(Reward::class);
    }
}
