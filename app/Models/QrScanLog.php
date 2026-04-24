<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;

class QrScanLog extends Model
{
    use CrudTrait;
    use HasFactory;

    protected $table = 'qr_scan_logs';

    protected $fillable = [
        'scan_code',
        'user_public_id',
        'qrcode_id',
        'usage_count',
        'max_usage',
        'image',
        'scanned_at',
    ];

    protected $casts = [
        'scanned_at' => 'datetime',
        'usage_count' => 'integer',
        'max_usage' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(UserPublic::class, 'user_public_id');
    }

    public function qrcode()
    {
        return $this->belongsTo(Qrcode::class);
    }

    public function getMerchantTitleAttribute()
    {
        return $this->qrcode?->promo?->merchant?->title ?? 'N/A';
    }

    protected static function booted()
    {
        static::addGlobalScope('merchant', function ($builder) {

            if (backpack_auth()->check()) {

                $user = backpack_user();

                if ($user->hasRole('merchant_admin')) {

                    $builder->whereHas('qrcode', function ($q) use ($user) {
                        $q->whereHas('promo', function ($promoQuery) use ($user) {
                            $promoQuery->where('merchant_id', $user->merchant_id);
                        });
                    });

                }
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
        $destination_path = "upload_bukti_scan/thumbnail";

        $this->storeImage($value, $attribute_name, $disk, $destination_path, $fileName = null);
    }

    public function storeImage($value, $attribute_name, $disk, $destination_path, $fileName = null)
    {
        // if the image was erased
        if ($value == null) {
            // delete the image from disk
            Storage::disk($disk)->delete(Str::replaceFirst('uploads/', '', $this->{$attribute_name}));

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
            if ($this->{$attribute_name}) {
                Storage::disk($disk)->delete(Str::replaceFirst('uploads/', '', $this->{$attribute_name}));
            }

            // 4. Save the public path to the database
            // but first, remove "public/" from the path, since we're pointing to it
            // from the root folder; that way, what gets saved in the db
            // is the public URL (everything that comes after the domain name)
            $public_destination_path = Str::replaceFirst('public/', '', $destination_path);

            $this->attributes[$attribute_name] = $disk . '/' . $public_destination_path . '/' . $filename;
        }
    }
}
