<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
       $getQuizzes = Quiz::orderBy('created_at','DESC')->get();
       return view('quiz.dashboard',compact('getQuizzes'));
    }

    public function startQuiz(Quiz $quiz)
    {
        $start = $quiz->startQuiz();
        if ($start) {
           return redirect()->route('quizAttempt',[$quiz]);
        } else {
            return redirect()->back()->with(['error' => 'Failed to start quiz! Please try again later']);
        }
        
    }
}
