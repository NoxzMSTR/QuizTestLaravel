<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuizAttempt extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function quiz()
    {
        return $this->hasOne(Quiz::class,'id','quiz_id');
    }
    public function quizAnswered()
    {
        return $this->hasMany(QuizAnswered::class,'quiz_attempt_id','id');
    }
}
