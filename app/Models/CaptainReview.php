<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CaptainReview extends Model
{
    use HasFactory;

    protected $fillable = [
        'captain_id',
        'client_id',
        'review',
        'rating',
    ];

    public function captain()
    {
        return $this->belongsTo(Captain::class);
    }
    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
