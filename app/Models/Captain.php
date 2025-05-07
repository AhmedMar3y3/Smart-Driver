<?php

namespace App\Models;

use App\Traits\HasImage;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;

class Captain extends Authenticatable
{
    use HasFactory, HasImage, HasApiTokens;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'is_approved',
        'completed_info',
        'rating',
        'views_count',
    ];

    protected $casts = [
        'is_approved' => 'boolean',
        'completed_info' => 'boolean',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'created_at',
        'updated_at',
    ];

    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = Hash::make($password);
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    public function info()
    {
        return $this->hasOne(CaptainInfo::class);
    }
    public function availabilities()
    {
        return $this->hasMany(CaptainAvailability::class);
    }

    public function reviews()
    {
        return $this->hasMany(CaptainReview::class);
    }

    public function verifyPassword(string $password): bool
    {
        return Hash::check($password, $this->password);
    }

    public function changePassword(string $newPassword): void
    {
        $this->password = $newPassword;
        $this->save();
    }
    public function subscriptions()
    {
        return $this->morphMany(Subscription::class, 'subscriber');
    }

    public function isSubscribed()
    {
        return $this->subscriptions()->where('status','active')->exists();
    }
}
