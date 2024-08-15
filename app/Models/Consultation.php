<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Consultation extends Model
{
    protected $table = 'consultations';
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
    public static function storeSubmission($request, $dpValue, $charactersAfterLastSlash, $salesCode)
    {
        return self::create([
            'name' => $request['name'],
            'nohp' => $request['nohp'],
            'product' => $request['produk'],
            'cara_bayar' => $request['payment_method'],
            'dp' => $dpValue,
            'tenor' => $request['tenor_pembelian'],
            'url' => $charactersAfterLastSlash,
            'sales_code' => $salesCode,
        ]);
    }
}
