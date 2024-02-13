<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Cocur\Slugify\Slugify;

class Promo extends Model
{
    use CrudTrait;
    use Sluggable, SluggableScopeHelpers;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'promos';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $guarded = ['id'];
    // protected $fillable = [];
    // protected $hidden = [];
    // protected $dates = [];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */

    public function sluggable(): array
    {
        return [
            'uri' => [
                'source' => ['name'],
            ],
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | ACCESSORS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */

    public static function boot()
    {
        parent::boot();

        static::deleting(function ($obj) {
            Storage::disk('uploads')->delete(Str::replaceFirst('uploads/', '', $obj->image));
        });
    }

    public function setImageAttribute($value)
    {
        $attribute_name = "image";
        $disk = "uploads";
        $destination_path = "promo/thumbnail";

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
