<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\PlateType;

class Plate extends Model
{
    use HasFactory;

    protected $fillable = [
        'number',
        'price',
        'status',
        'phone',
        'address',
        'type',
        'emirate_id',
        'client_id',
        'plate_code_id',
    ];

    protected $casts = [
        'status' => 'integer',
        // 'type' => PlateType::class,
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
    
    public function emirate()
    {
        return $this->belongsTo(Emirate::class);
    }

    public function plateCode()
    {
        return $this->belongsTo(PlateCode::class);
    }
}
