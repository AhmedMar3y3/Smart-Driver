<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Emirate extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public function plates()
    {
        return $this->hasMany(Plate::class);
    }

    public function plateCodes()
    {
        return $this->hasMany(PlateCode::class);
    }
}
