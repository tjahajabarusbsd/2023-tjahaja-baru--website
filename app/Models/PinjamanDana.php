<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PinjamanDana extends Model
{
    protected $table = 'pinjaman_dana';

    protected $fillable = [
        'name',
        'nohp',
        'tipe',
        'tipe_lain',
        'tahun',
        'estimasi_harga',
        'want_dana',
        'tenor',
        'estimasi_angsuran',
        'id_user'
    ];

    // protected $guarded = [];
    
    public $timestamps = true;

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
