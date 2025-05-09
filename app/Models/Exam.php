<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    use HasFactory;

    protected $fillable = ['question_subscription_id', 'start_time', 'end_time', 'status', 'score'];

    public function subscription()
    {
        return $this->belongsTo(QuestionSubscription::class, 'question_subscription_id');
    }

    public function answers()
    {
        return $this->hasMany(ExamAnswer::class, 'exam_id');
    }
}