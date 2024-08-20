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

    public static function storeSubmission(array $validatedData, $user)
    {
        return self::create([
            'name' => $validatedData['sky_name'],
            'nohp' => $validatedData['sky_phone_number'],
            'alamat' => $validatedData['sky_alamat'],
            'tipe' => $validatedData['sky_tipe'],
            'kendala' => $validatedData['sky_kendala'],
            'user_id' => $user->id,
        ]);
    }
}
