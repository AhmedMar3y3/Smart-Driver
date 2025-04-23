<?php

namespace App\Models;

use App\Traits\HasImage;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Helpers\ImageUploadHelper;

class Brand extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'logo'];

    public function cars()
    {
        return $this->hasMany(Car::class);
    }

    public function hasCars()
    {
        return $this->cars()->exists();
    }


    public function setLogoAttribute($value)
    {
        if ($value) {
            $directory = strtolower(class_basename($this));
            $this->attributes['logo'] = ImageUploadHelper::uploadImage($value, $directory);
        }
    }

    public function getLogoAttribute($value)
    {
        return $value ? rtrim(env('APP_URL'), '/') . $value : null;
    }
}
