<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    use HasFactory, Translatable;
    protected $with = ['translations'];
    public $translatedAttributes = ['title', 'description'];
    protected $fillable = [
        'type',
        'price',
        'duration',
        'ad_duration',
        'allowed_ads',
        'allowed_ads_per_month',
    ];
    protected $casts = [
        'type' => 'string',
    ];

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }
}
