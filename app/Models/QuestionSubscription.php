<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuestionSubscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'question_package_id',
        'status',
        'payment_status',
        'invoice_id',
        'invoice_url',
    ];

    public function subscriber()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }

    public function package()
    {
        return $this->belongsTo(QuestionPackage::class, 'question_package_id');
    }

    public function exams()
    {
        return $this->hasMany(Exam::class, 'question_subscription_id');
    }

    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }
}