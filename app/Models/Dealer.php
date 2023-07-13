<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dealer extends Model
{
    protected $table = 'dealers';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $guarded = ['id'];
    // protected $fillable = [];
    // protected $hidden = [];
    // protected $dates = [];

    // If you have timestamps (created_at and updated_at) in your table
    public $timestamps = true;

    // If you want to exclude timestamps
    // public $timestamps = false;
}
