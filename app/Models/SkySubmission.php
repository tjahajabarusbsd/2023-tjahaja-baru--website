<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SkySubmission extends Model
{
    use HasFactory;

    protected $table = 'sky_submissions';
    protected $guarded = ['id'];
    protected $fillable = [
        'name',
        'nohp',
        'alamat',
        'tipe',
        'kendala',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
