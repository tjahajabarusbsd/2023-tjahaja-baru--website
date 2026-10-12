<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeatureStatus extends Model
{
    use CrudTrait;
    use HasFactory;

    protected $fillable = [
        'key',
        'label',
        'is_active',
        'maintenance_message',
        'maintenance_until',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'maintenance_until' => 'datetime',
    ];

    protected static function booted()
    {
        static::saving(function (FeatureStatus $f) {
            if ($f->is_active) {
                $f->maintenance_message = null;
                $f->maintenance_until = null;
            }
        });
    }
}
