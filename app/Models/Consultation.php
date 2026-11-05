<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;

class Consultation extends Model
{
    use CrudTrait;

    // Pilihan "Rencana Beli" di form (key disimpan di database, label dipakai di form, WA, dan Backpack)
    public const RENCANA_BELI = [
        'minggu_ini'  => 'Dalam minggu ini',
        'bulan_ini'   => 'Dalam bulan ini',
        'lihat_lihat' => 'Masih lihat-lihat',
    ];

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
            'name'         => $validatedData['name'],
            'nohp'         => $validatedData['nohp'],
            'product'      => $validatedData['produk'],
            'rencana_beli' => $validatedData['rencana_beli'] ?? null,
            'cara_bayar'   => $validatedData['cara_bayar'],
            'dp'           => $dpValue,
            'tenor'        => $validatedData['tenor'],
            'url'          => $charactersAfterLastSlash,
            'sales_code'   => $salesCode,
            'utm_campaign' => $utmCampaign
        ]);
    }
}
