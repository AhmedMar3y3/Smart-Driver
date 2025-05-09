<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class QuestionPackage extends Model
{
    use Translatable;

    protected $table = 'question_packages';
    public $translatedAttributes = ['title', 'description'];
    protected $fillable = ['level', 'price', 'time_limit'];

    public function questions()
    {
        return $this->hasMany(Question::class, 'question_package_id');
    }

    public function subscriptions()
    {
        return $this->hasMany(QuestionSubscription::class, 'question_package_id');
    }
}