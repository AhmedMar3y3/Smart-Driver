<?php

namespace App\Models;

use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CaptainInfo extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = [
        'captain_id',
        'name',
        'email',
        'phone',
        'ID_card',
        'country',
        'address',
        'bio',
        'driving_license',
        'issued_by',
        'issued_at',
        'expires_at',
        'has_car',
        'vehicle_title',
        'vehicle_model',
        'vehicle_plate',
        'vehicle_type',
    ];
    protected $casts = [
        'has_car' => 'boolean',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    protected $imageFields = [
        'personal_image',
        'car_image',
        'license_image',
        'residence_image',
    ];
    public function captain()
    {
        return $this->belongsTo(Captain::class);
    }

    public function addMediaFromRequest(array $fields)
    {
        foreach ($fields as $field) {
            if (request()->hasFile($field)) {
                $this->addMedia(request()->file($field))->toMediaCollection($field);
            }
        }
    }
}