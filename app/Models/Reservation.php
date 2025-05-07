<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'captain_id',
        'client_id',
        'availability_id',
        'status',
        'name',
        'phone',
    ];
    protected $casts = [
        'status' => 'string',
    ];
    public function captain()
    {
        return $this->belongsTo(Captain::class);
    }
    public function availability()
    {
        return $this->belongsTo(CaptainAvailability::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }
}
