<?php

namespace App\Models;

use App\Traits\HasImage;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Hash;
use App\Services\SendVerificationCodeService;
use Illuminate\Notifications\Notifiable;

class Client extends Authenticatable
{
    use HasFactory, HasImage, HasApiTokens, Notifiable;

    protected $fillable = [
        'name',
        'image',
        'phone',
        'email',
        'password',
        'isSubscribed',
        'subscription_type',
        'is_verified',
        'code',
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

    public function login()
    {
        return $this->createToken('client-token')->plainTextToken;
    }

    public function sendVerificationCode()
    {
        $this->update([
            'code'=>123456,
            // 'code' => random_int(100000, 999999),
        ]);

        //  (new SendVerificationCodeService())->sendCodeToUser($this);
    }

     public function markAsVerified()
    {
        $this->update([
            'is_verified' => true,
            'code' => null,
        ]);
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
    public function changePassword(string $newPassword): void
    {
        $this->password = $newPassword;
        $this->save();
    }

    public function verifyPassword(string $password): bool
    {
        return Hash::check($password, $this->password);
    }

    public function subscriptions()
    {
        return $this->morphMany(Subscription::class, 'subscriber');
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    public function questionSubscriptions()
    {
        return $this->hasMany(QuestionSubscription::class);
    }
    public function hasActiveSubscription($packageId): bool
    {
        return $this->questionSubscriptions()->where('status', 'active')->where('question_package_id', $packageId)->exists();
    }

    public function hasCompletedSubscription($packageId): bool
    {
        return $this->questionSubscriptions()->where('status', 'completed')->where('question_package_id', $packageId)->exists();
    }

}
