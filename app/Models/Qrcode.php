<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use App\User;

class Qrcode extends Model
{
    use CrudTrait;
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'merchant_id',
        'nama_qrcode',
        'kode',
        'poin',
        'masa_berlaku_mulai',
        'masa_berlaku_selesai',
        'aktif',
        'max_penggunaan',
        'jumlah_penggunaan',
        'created_by'
    ];

    protected $casts = [
        'masa_berlaku_mulai' => 'datetime',
        'masa_berlaku_selesai' => 'datetime',
        'aktif' => 'boolean',
    ];

    // Relasi ke user yang membuat
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function merchant()
    {
        return $this->belongsTo(Merchant::class);
    }

    // Scope untuk QR aktif
    public function scopeAktif($query)
    {
        return $query->where('aktif', true);
    }

    public function masihBerlaku()
    {
        if (now()->lt($this->masa_berlaku_mulai) || now()->gt($this->masa_berlaku_selesai))
            return false;

        return true;
    }

    // cek max penggunaan
    public function maxPenggunaan()
    {
        if ($this->max_penggunaan && $this->jumlah_penggunaan >= $this->max_penggunaan)
            return false;

        return true;
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($qrcode) {
            if (empty($qrcode->created_by)) {
                $qrcode->created_by = auth()->id();
            }
        });
    }
}
