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
        'code',
        'is_code'
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

    public function sendVerificationCodeForCaptain()
    {
        $this->update([
            'code' => 123456,
            // 'code' => random_int(100000, 999999),
        ]);

        //  (new SendVerificationCodeService())->sendCodeToUser($this);
    }

    public function updatePassword($password)
    {
        $this->update([
            'password' => $password,
            'code' => null,
            'is_code' => false,
        ]);
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
        return $this->subscriptions()->where('status', 'active')->exists();
    }
}
