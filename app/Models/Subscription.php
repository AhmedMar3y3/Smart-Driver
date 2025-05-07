<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'subscriber_id',
        'subscriber_type',
        'package_id',
        'start_date',
        'end_date',
        'status',
        'payment_status',
        'invoice_id',
        'invoice_url',
    ];

    public function subscriber()
    {
        return $this->morphTo();
    }

    public function package()
    {
        return $this->belongsTo(Package::class);
    }
}
