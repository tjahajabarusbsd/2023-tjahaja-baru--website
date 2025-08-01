<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPublicProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_public_id',
        'tgl_lahir',
        'alamat',
        'jenis_kelamin',
        'total_points',
        'foto_profil',
        'foto_ktp',
        'foto_kk',
    ];

    public function userPublic()
    {
        return $this->belongsTo(UserPublic::class, 'user_public_id');
    }
}
