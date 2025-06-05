<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\CarType;

class Car extends Model
{
    use HasFactory;


    protected $fillable = [
        'name',
        'category',
        'year',
        'price',
        'phone',
        'distance',
        'color',
        'type',
        'status',
        'additional_info',
        'address',
        'brand_id',
        'client_id',
        'category_id',
        'expires_at',
        'expiry_status',
    ];
    protected $casts = [
        'type' => CarType::class,
        'status' => 'integer',
        'expiry_status' => 'string',
    ];

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function images()
    {
        return $this->hasMany(CarImage::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function scopeActive($query)
    {
        return $query->where('expiry_status', 'active');
    }

    public function scopeExpired($query)
    {
        return $query->where('expiry_status', 'expired');
    }
}
