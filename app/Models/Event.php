<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;
use Carbon\Carbon;

class Event extends Model
{
    use CrudTrait;
    use HasFactory;

    public const TYPES = [
        'online' => 'Online',
        'offline' => 'Offline',
    ];

    public const CHECKIN_TOKEN_PREFIX = 'EVT-';

    protected $fillable = [
        'name',
        'description',
        'image',
        'start_date',
        'end_date',
        'type',
        'is_active',
        'checkin_enabled',
        'checkin_token',
        'checkin_open_at',
        'checkin_close_at',
        'location',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'is_active' => 'boolean',
        'checkin_enabled' => 'boolean',
        'checkin_open_at' => 'datetime',
        'checkin_close_at' => 'datetime',
    ];

    public function scopeOngoing($query)
    {
        $today = now()->toDateString();
        return $query->where('is_active', true)
            ->whereDate('start_date', '<=', $today)
            ->whereDate('end_date', '>=', $today);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function checkins()
    {
        return $this->hasMany(EventCheckin::class);
    }

    /**
     * Jendela waktu check-in. Null berarti tanpa batas di sisi tersebut.
     * Default: seluruh tanggal event (start_date 00:00 s/d end_date 23:59).
     */
    public function checkinWindow(): array
    {
        $from = $this->checkin_open_at
            ? $this->checkin_open_at->copy()
            : ($this->start_date ? $this->start_date->copy()->startOfDay() : null);

        $to = $this->checkin_close_at
            ? $this->checkin_close_at->copy()
            : ($this->end_date ? $this->end_date->copy()->endOfDay() : null);

        return [$from, $to];
    }

    public function checkinOpen(): bool
    {
        [$from, $to] = $this->checkinWindow();

        if ($from && now()->lt($from)) {
            return false;
        }

        if ($to && now()->gt($to)) {
            return false;
        }

        return true;
    }

    /**
     * Token yang di-encode menjadi QR event. Dibuat sekali, dipakai selamanya.
     */
    public function ensureCheckinToken(bool $save = true): string
    {
        if (empty($this->checkin_token)) {
            $this->checkin_token = self::CHECKIN_TOKEN_PREFIX . Str::uuid()->toString();

            if ($save && $this->exists) {
                $this->saveQuietly();
            }
        }

        return $this->checkin_token;
    }

    public static function boot()
    {
        parent::boot();

        static::creating(function ($event) {
            if (empty($event->checkin_token)) {
                $event->checkin_token = self::CHECKIN_TOKEN_PREFIX . Str::uuid()->toString();
            }
        });

        static::deleting(function ($obj) {
            Storage::disk('uploads')->delete(Str::replaceFirst('uploads/', '', $obj->image));
        });
    }

    public function setImageAttribute($value)
    {
        $attribute_name = "image";
        $disk = "uploads";
        $destination_path = "events/thumbnail";

        $this->storeImage($value, $attribute_name, $disk, $destination_path, $fileName = null);
    }

    public function storeImage($value, $attribute_name, $disk, $destination_path, $fileName = null)
    {
        // if the image was erased
        if ($value == null) {
            // delete the image from disk
            $previousImagePath = Str::replaceFirst('uploads/', '', $this->{$attribute_name});

            if ($previousImagePath && Storage::disk($disk)->exists($previousImagePath)) {
                Storage::disk($disk)->delete($previousImagePath);
            }

            // set null in the database column
            $this->attributes[$attribute_name] = null;
        }

        // if a base64 was sent, store it in the db
        if (Str::startsWith($value, 'data:image')) {
            // 0. Make the image
            $image = Image::make($value);

            // 1. Generate a filename with original extension.
            $extension = explode('/', explode(':', substr($value, 0, strpos($value, ';')))[1])[1];
            $filename = md5($value . time()) . '.' . $extension;

            // 2. Store the image on disk.
            Storage::disk($disk)->put($destination_path . '/' . $filename, $image->stream());

            // 3. Delete the previous image, if there was one.
            $previousImagePath = Str::replaceFirst('uploads/', '', $this->{$attribute_name});

            if ($previousImagePath && Storage::disk($disk)->exists($previousImagePath)) {
                Storage::disk($disk)->delete($previousImagePath);
            }

            // 4. Save the public path to the database
            // but first, remove "public/" from the path, since we're pointing to it
            // from the root folder; that way, what gets saved in the db
            // is the public URL (everything that comes after the domain name)
            $public_destination_path = Str::replaceFirst('public/', '', $destination_path);

            $this->attributes[$attribute_name] =  $disk . '/' . $public_destination_path . '/' . $filename;
        }
    }
}