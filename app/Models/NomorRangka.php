<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;
use App\User;

class NomorRangka extends Model
{
    use CrudTrait;
    protected $table = 'nomor_rangkas';
    protected $fillable = [
        'nomor_rangka',
        'phone_number',
        'user_public_id',
        'ktp',
        'kk',
        'nama_model',
        'nomor_plat',
        'status_verifikasi'
    ];

    // public function user()
    // {
    //     return $this->belongsTo(User::class);
    // }

    public function user()
    {
        return $this->belongsTo(UserPublic::class, 'user_public_id');
    }
}
