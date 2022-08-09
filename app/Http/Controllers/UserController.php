<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Mail\SubscribeQuiz;
use Illuminate\Http\Request;
use App\Models\UserQuizSubscription;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    public function subscribe(Quiz $quiz)
    {
        UserQuizSubscription::updateOrCreate([
            'user_id' => Auth::user()->id,
            'quiz_id' => $quiz->id,
            'is_subscribed' => 'yes'
        ]);
        return redirect()->route('dashboard')->with(['message'=>'You Have Successfully Subscribe to Quiz']);
    }

    public function subscribeJobs()
    {
        $subs = UserQuizSubscription::where('is_subscribed','yes')->get();
        $userData = [];
     
        foreach ($subs as $key => $data) {
            $quiz = Quiz::where('id',$data->quiz_id)->first();
            $quizAttempts = $quiz->quizAttempt()->where('status','completed')->get();
            foreach ($quizAttempts as $key => $quiz) {
                $userName = $quiz->user()->first()->name;
                $quizAns = $quiz->quizAnswered()->get();
                $totalQues = $quizAns->count();
                $totalCorrectAns = 0;
                foreach ($quizAns as $key => $value) {
                    if (!$value->is_false) {
                        $totalCorrectAns++;
                    }
                }
                $totalPercent = round($totalCorrectAns / $totalQues * 100,2);
                $userData[] =[
                    'user' => $userName,
                    'total' => $totalPercent,
                ];
            }
            Mail::to($data->user()->first())->send(new SubscribeQuiz($data->user()->first(),$userData));
        }
      
        
    }
}
