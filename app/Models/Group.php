<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\Storage;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Cocur\Slugify\Slugify;

class Group extends Model
{
    use CrudTrait;
    use Sluggable, SluggableScopeHelpers;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'groups';
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

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function variants()
    {
        return $this->hasMany(Variant::class);
    }

    public function group_product_specs()
    {
        return $this->hasMany(GroupProductSpec::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

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
            Storage::disk('uploads')->delete(Str::replaceFirst('uploads/', '', $obj->banner));
            Storage::disk('uploads')->delete(Str::replaceFirst('uploads/', '', $obj->logo));
        });
    }

    public function setImageAttribute($value)
    {
        $attribute_name = "image";
        $disk = "uploads";
        $destination_path = "products/groups/thumbnail";

        $this->storeImage($value, $attribute_name, $disk, $destination_path, $fileName = null);
    }

    public function setBannerAttribute($value)
    {
        $attribute_name = "banner";
        $disk = "uploads";
        $destination_path = "products/groups/banner";

        $this->storeImage($value, $attribute_name, $disk, $destination_path, $fileName = null);
    }

    public function setLogoAttribute($value)
    {
        $attribute_name = "logo";
        $disk = "uploads";
        $destination_path = "products/groups/logo";

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
            // Storage::disk($disk)->delete(Str::replaceFirst('uploads/', '', $this->{$attribute_name}));
            $currentImagePath = $this->{$attribute_name};
            if (!empty($currentImagePath)) {
                $pathToDelete = Str::replaceFirst('uploads/', '', $currentImagePath);
                Storage::disk($disk)->delete($pathToDelete);
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
