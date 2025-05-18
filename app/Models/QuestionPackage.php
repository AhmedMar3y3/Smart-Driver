<?php

namespace App\Models;

use App\Traits\HasImage;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class QuestionPackage extends Model
{
    use Translatable, HasImage;

    protected $table = 'question_packages';
    public $translatedAttributes = ['title', 'description'];
    protected $fillable = ['level_order', 'price', 'time_limit'];

    public function questions()
    {
        return $this->hasMany(Question::class, 'question_package_id');
    }

    public function subscriptions()
    {
        return $this->hasMany(QuestionSubscription::class, 'question_package_id');
    }
}