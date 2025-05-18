<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlateCode extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'emirate_id',
    ];
    public function emirate()
    {
        return $this->belongsTo(Emirate::class);
    }
    public function plates()
    {
        return $this->hasMany(Plate::class);
    }
}
