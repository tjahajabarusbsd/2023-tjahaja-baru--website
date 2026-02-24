<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use App\User;
use Illuminate\Support\Str;

class Qrcode extends Model
{
    use CrudTrait;
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'nama_qrcode',
        'merchant_id',
        'promo_id',
        'benefit',
        'masa_berlaku_mulai',
        'masa_berlaku_selesai',
        'jam_mulai',
        'jam_selesai',
        'hari_aktif',
        'max_penggunaan',
        'jumlah_penggunaan',
        'aktif',
        'kode',
        'created_by'
    ];

    protected $casts = [
        'masa_berlaku_mulai' => 'datetime',
        'masa_berlaku_selesai' => 'datetime',
        'aktif' => 'boolean',
        'max_penggunaan' => 'integer',
        'jumlah_penggunaan' => 'integer',
        'hari_aktif' => 'array',
    ];

    // Relasi ke user yang membuat
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function merchant()
    {
        return $this->belongsTo(Merchant::class, 'merchant_id');
    }

    public function activityLogs()
    {
        return $this->morphMany(ActivityLog::class, 'source');
    }

    public function promo()
    {
        return $this->belongsTo(Promo::class);
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

    // Cek jam aktif
    public function jamAktif()
    {
        if ($this->jam_mulai && $this->jam_selesai) {
            $currentTime = now()->format('H:i:s');
            if ($currentTime < $this->jam_mulai || $currentTime > $this->jam_selesai) {
                return false;
            }
        }

        return true;
    }

    // Cek hari aktif
    public function hariAktif()
    {
        if ($this->hari_aktif && is_array($this->hari_aktif)) {
            $today = strtolower(now()->format('D'));

            $map = [
                'mon' => 'mon',
                'tue' => 'tue',
                'wed' => 'wed',
                'thu' => 'thu',
                'fri' => 'fri',
                'sat' => 'sat',
                'sun' => 'sun',
            ];

            $todayKey = strtolower(substr($today, 0, 3));

            if (!in_array($todayKey, $this->hari_aktif)) {
                return false;
            }
        }

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

        static::creating(function ($qr) {

            if (empty($qr->created_by)) {
                $qr->created_by = auth()->id();
            }

            if (empty($qr->kode)) {
                $qr->kode = 'QR-' . strtoupper((Str::uuid())->toString());
            }

        });
    }
}
