<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CaptainAvailability extends Model
{
    use HasFactory;

    protected $fillable = [
        'captain_id',
        'date',
        'from',
        'to',
        'is_reserved',
    ];
    protected $casts = [
        'date' => 'date',
        'is_reserved' => 'boolean',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];


    public function captain()
    {
        return $this->belongsTo(Captain::class);
    }
}
