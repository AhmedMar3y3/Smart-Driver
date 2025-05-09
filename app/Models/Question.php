<?php

namespace App\Models;

use App\Traits\HasImage;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory, HasImage;

    protected $fillable = ['question_package_id', 'question_text', 'image'];

    public function package()
    {
        return $this->belongsTo(QuestionPackage::class, 'question_package_id');
    }

    public function choices()
    {
        return $this->hasMany(Choice::class, 'question_id');
    }

    public function examAnswers()
    {
        return $this->hasMany(ExamAnswer::class, 'question_id');
    }
}