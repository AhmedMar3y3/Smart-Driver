<?php

namespace App\Models;

use App\Traits\HasImage;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Choice extends Model
{
    use HasFactory, HasImage;

    protected $fillable = ['question_id', 'choice_text', 'is_correct', 'image','type'];
    protected $casts = [
        'is_correct' => 'boolean',
        'type' => 'string',
    ];

    public function question()
    {
        return $this->belongsTo(Question::class, 'question_id');
    }

    public function examAnswers()
    {
        return $this->hasMany(ExamAnswer::class, 'choice_id');
    }
}