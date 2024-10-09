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
    public static function storeSubmission($validatedData, $dpValue, $charactersAfterLastSlash, $salesCode, $utmCampaign)
    {
        return self::create([
            'name'       => $validatedData['name'],
            'nohp'       => $validatedData['nohp'],
            'product'    => $validatedData['produk'],
            'cara_bayar' => $validatedData['cara_bayar'],
            'dp'         => $dpValue,
            'tenor'      => $validatedData['tenor'],
            'url'        => $charactersAfterLastSlash,
            'sales_code' => $salesCode,
            'utm_campaign' => $utmCampaign
        ]);
    }
}
