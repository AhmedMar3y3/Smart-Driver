<?php

namespace App\Models;

use App\Traits\HasImage;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Hash;

class Client extends Authenticatable
{
    use HasFactory, HasImage, HasApiTokens;

    protected $fillable = [
        'name',
        'image',
        'phone',
        'email',
        'password',
        'isSubscribed',
        'subscription_type',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'isSubscribed' => 'boolean',
        'subscription_type' => 'integer',
    ];

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }

    public static function createWithGoogle(array $googleData)
    {
        return static::create([
            'name' => $googleData['name'],
            'email' => $googleData['email'],
            'image' => $googleData['avatar'],
            'password' => Hash::make(uniqid()),
            'phone' => 'google',
        ]);
    }

    public function cars()
    {
        return $this->hasMany(Car::class);
    }

    public function plates()
    {
        return $this->hasMany(Plate::class);
    }
}
