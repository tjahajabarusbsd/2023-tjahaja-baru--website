<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NomorRangka extends Model
{
    protected $table = 'nomor_rangkas';
    protected $fillable = ['nomor_rangka','user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
