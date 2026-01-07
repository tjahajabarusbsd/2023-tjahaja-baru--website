<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;

class Dealer extends Model
{
    use CrudTrait;

    protected $table = 'dealers';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $guarded = ['id'];
    protected $fillable = [
        'nama_dealer',
        'kode_dealer',
    ];
    // protected $hidden = [];
    // protected $dates = [];

    // If you have timestamps (created_at and updated_at) in your table
    public $timestamps = true;

    // If you want to exclude timestamps
    // public $timestamps = false;
}
