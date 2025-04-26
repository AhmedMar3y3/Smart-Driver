<?php

namespace App\Models;

use App\Traits\HasImage;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Captain extends Authenticatable
{
    use HasFactory, HasImage, HasApiTokens;

    protected $fillable = ['is_approved'];
}
