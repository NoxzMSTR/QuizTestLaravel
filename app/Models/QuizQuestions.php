<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuizQuestions extends Model
{
    use HasFactory;
    protected $fillable = [
        'quiz_id',
        'quiz_question',
        'quiz_answer',
        'quiz_correct_answer',
        'type'
    ];
}
