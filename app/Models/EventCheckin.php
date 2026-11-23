<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class EventCheckin extends Model
{
    use CrudTrait;
    use HasFactory;

    protected $table = 'event_checkins';

    protected $fillable = [
        'event_id',
        'user_public_id',
        'checkin_code',
        'checked_in_at',
    ];

    protected $casts = [
        'checked_in_at' => 'datetime',
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function user()
    {
        return $this->belongsTo(UserPublic::class, 'user_public_id');
    }

    protected static function booted()
    {
        static::creating(function (EventCheckin $checkin) {
            if (empty($checkin->checkin_code)) {
                $checkin->checkin_code = self::generateCheckinCode();
            }
        });
    }

    /**
     * Kode tiket check-in: CHK-XXXXXXXX
     */
    public static function generateCheckinCode(): string
    {
        do {
            $code = 'CHK-' . strtoupper(Str::random(8));
        } while (self::where('checkin_code', $code)->exists());

        return $code;
    }
}
