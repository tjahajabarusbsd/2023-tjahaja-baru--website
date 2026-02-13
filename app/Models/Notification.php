<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_public_id',
        'source_type',
        'source_id',
        'category',
        'title',
        'description',
        'is_read',
        'read_at',
    ];

    /**
     * Relasi ke UserPublic
     */
    public function userPublic()
    {
        return $this->belongsTo(UserPublic::class, 'user_public_id');
    }

    /**
     * Relasi polymorphic ke sumber notifikasi (contoh: Order, Payment, Service, dll.)
     */
    public function source()
    {
        return $this->morphTo();
    }

    /**
     * Scope untuk filter notifikasi yang belum dibaca
     */
    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }

    /**
     * Tandai sebagai sudah dibaca
     */
    public function markAsRead()
    {
        $this->update([
            'is_read' => true,
            'read_at' => now(),
        ]);
    }
}
