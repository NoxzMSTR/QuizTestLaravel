<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Quiz extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'duration',
        'short_description'
    ];
    public function quizQues()
    {
        return $this->hasMany(QuizQuestions::class,'quiz_id','id');
    }
    
    public function quizAttempt()
    {
        return $this->hasMany(QuizAttempt::class,'quiz_id','id');
    }

    public function startQuiz()
    {
       $start = $this->quizAttempt()->create([
            'user_id' => Auth::user()->id
        ]);
        if ($start) {
            return true;
        }else{
            return false;
        }
    }

}
