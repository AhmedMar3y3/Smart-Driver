<?php

namespace App\Models;

use App\Traits\HasImage;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    use HasFactory, HasImage;

    protected $fillable = [
        'name',
        'image',
    ];
    protected $hidden = [
        'created_at',
        'updated_at',
    ];

}
