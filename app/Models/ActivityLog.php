<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    use CrudTrait;
    use HasFactory;

    protected $fillable = [
        'user_public_id',
        'source_type',
        'source_id',
        'type',
        'title',
        'description',
        'points',
        'activity_date',
    ];

    protected $casts = [
        'activity_date' => 'datetime',
    ];

    /**
     * Relasi ke user_public
     */
    public function user()
    {
        return $this->belongsTo(UserPublic::class, 'user_public_id');
    }

    /**
     * Polymorphic relationship
     */
    public function source()
    {
        return $this->morphTo();
    }

    public function getMerchantTitleAttribute()
    {
        if (!$this->source)
            return null;

        if (method_exists($this->source, 'merchant')) {
            return $this->source->merchant->title ?? null;
        }

        return null;
    }

}
