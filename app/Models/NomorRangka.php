<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\ImageManagerStatic as Image;

class NomorRangka extends Model
{
    use CrudTrait;
    protected $table = 'nomor_rangkas';
    protected $fillable = [
        'nomor_rangka',
        'phone_number',
        'user_public_id',
        'ktp',
        'kk',
        'nama_model',
        'nomor_plat',
        'status_verifikasi'
    ];

    // public function user()
    // {
    //     return $this->belongsTo(User::class);
    // }

    public function user()
    {
        return $this->belongsTo(UserPublic::class, 'user_public_id');
    }

    public static function boot()
    {
        parent::boot();

        static::deleting(function ($obj) {
            Storage::disk('uploads')->delete(Str::replaceFirst('uploads/', '', $obj->ktp));
            Storage::disk('uploads')->delete(Str::replaceFirst('uploads/', '', $obj->kk));
        });
    }

    public function setKtpAttribute($value)
    {
        $attribute_name = "ktp";
        $disk = "uploads";
        $destination_path = "users/ktp/thumbnail";

        $this->storeImage($value, $attribute_name, $disk, $destination_path, $fileName = null);
    }

    public function setKkAttribute($value)
    {
        $attribute_name = "kk";
        $disk = "uploads";
        $destination_path = "users/kk/thumbnail";

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
