<?php

namespace App\Models;

use App\Enums\Status;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plate extends Model
{
    use HasFactory;

    protected $fillable = [
        'number',
        'price',
        'status',
        'phone',
        'address',
        'emirate_id',
        'client_id',
    ];

    protected $casts = [
        'status' => 'integer',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
    public function emirate()
    {
        return $this->belongsTo(Emirate::class);
    }
}
