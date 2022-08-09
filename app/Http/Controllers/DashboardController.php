<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
       $getQuizzes = Quiz::orderBy('created_at','DESC')->get();
       $TotalQuizzes = $getQuizzes->count();
       $TotalUsers = User::all()->count();
       return view('quiz.dashboard',compact('getQuizzes','TotalQuizzes','TotalUsers'));
    }

    public function startQuiz(Quiz $quiz)
    {
        $start = $quiz->startQuiz();
        if ($start) {
           return redirect()->route('quizAttempt',[$start->id]);
        } else {
            return redirect()->back()->with(['error' => 'Failed to start quiz! Please try again later']);
        }
        
    }
}
