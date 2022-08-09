<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\QuizAnswered;
use App\Models\QuizAttempt;
use Illuminate\Http\Request;
use App\Models\QuizQuestions;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Validation\ValidationException;

class QuizController extends Controller
{
    public function quizView()
    {
        $getQuizzes = Quiz::all();
        return view('quiz.pages.view-quiz',compact('getQuizzes'));
    }
    public function addQuiz(Request $request)
    {
       $validate = $request->validate([
        'title' => 'required|max:50',
        'average' => 'required|max:100',
        'duration' => 'required|date_format:H:i:s',
       ]);
       
       Quiz::create([
        'title' => $request->title,
        'duration' => $request->duration,
        'average' => $request->average,
        'short_description' => $request->short_description,
       ]);

       return Response::json([
        'message' => 'Quiz added successfully.'
       ],200);
    }

    public function viewQuizQues(Quiz $quiz)
    {
        $quizQues = QuizQuestions::where('quiz_id',$quiz->id)->orderBy('created_at','ASC')->get();
        return view('quiz.pages.add-quiz-ques',compact('quiz','quizQues'));
    }

    public function addQuizQues(Request $request,Quiz $quiz)
    {
       $validate = $request->validate([
        'outer_list.*.quiz_question' => 'required|string',
        'outer_list.*.type' => 'required|string',
        'outer_list.*.inner_list.*.quiz_answer' => 'required|string',
       ]);
       $quizAns = [];
       $quizCrAns = [];
       QuizQuestions::where('quiz_id',$quiz->id)->delete();
       foreach ($request->outer_list as $key => $value) {
   
            foreach ($value['inner_list'] as $key2 => $value2) {
                $quizAns[] = $value2['quiz_answer'];
                isset($value2['quiz_correct_answer'])? $quizCrAns[] = $key2 : null ;
            }
            if (empty($quizCrAns)) {
                throw ValidationException::withMessages(['message' => 'Quiz Correct Answer is required']);
            }
            QuizQuestions::create([
                'quiz_id' => $quiz->id,
                'quiz_question' => $value['quiz_question'],
                'type' => $value['type'],
                'quiz_answer' => implode(',',$quizAns),
                'quiz_correct_answer' => implode(',',$quizCrAns),
            ]);
            $quizAns = [];
            $quizCrAns = [];
       }
      

       return Response::json([
        'message' => 'Quiz Question added successfully.'
       ],200);
    }

    public function quizAttemptView(QuizAttempt $quiz)
    {
        $quizAtmpt = $quiz;
        $quiz = $quiz->quiz()->first();
        $currentDate = Carbon::now();
        $dateDuration = Carbon::parse($quizAtmpt->created_at)->addMinutes($this->minutes($quiz->duration));
        $currentElaps =   $dateDuration->diff($currentDate);
        $currentElaps = $dateDuration->diff($currentDate)->h.':'.$currentElaps->i.':'.$currentElaps->s;
        return view('quiz.pages.start-quiz-ques',compact('quiz','quizAtmpt','currentElaps'));
    }
    public function addAttemptedQuizQues(Request $request,QuizAttempt $quiz)
    {
       $validate = $request->validate([
        'ques' => 'required|array',
        'single' => 'required|array',
        'multi' => 'required|array'
       ]);
       $check = '';
       $data = '';
       foreach ($request->ques as $key => $value) {
            $quizQ = $quiz->quiz()->first()->quizQues()->where('id',$value)->first();
            if ($quizQ->type == 'multiple') {
                $data = implode(',',$request->multi[$value]);
                $quizQ->quiz_correct_answer == implode(',',$request->multi[$value]) ? $check = false : $check = true;
            }else{
                $data = $request->single[$value];
                $quizQ->quiz_correct_answer == $request->single[$value] ? $check = false : $check = true;
            }
            $quiz->update([
                'status' => 'completed'
            ]);
            QuizAnswered::create([
                'quiz_attempt_id' => $quiz->id,
                'quiz_question_id' => $value,
                'quiz_answered' => $data,  
                'is_false' => $check,
            ]);
       }
       return Response::json([
        'message' => 'Quiz Submitted Successfully.',
        'url' => route('viewReview',[$quiz])
       ],200);
    }
    function minutes($time){
        $time = explode(':', $time);
        return ($time[0]*60) + ($time[1]) + ($time[2]/60);
    }

    public function viewQuizReview(QuizAttempt $quiz)
    {
        $quizAns = $quiz->quizAnswered()->get();
        $totalQues = $quizAns->count();
        $totalCorrectAns = 0;
        foreach ($quizAns as $key => $value) {
            if (!$value->is_false) {
                $totalCorrectAns++;
            }
        }
        $totalPercent = round($totalCorrectAns / $totalQues * 100,2);
        
        $quiz = $quiz->quiz()->first();
        $testAverage = 'Total Average for the quiz is : '.$quiz->average;
        if ($totalPercent <= $quiz->average) {
            $scored = "Total Your Percentage on Quiz is : ".$totalPercent;
            $status = 'Sorry you didnt pass';
        }else{
            $scored = "Total Your Percentage on Quiz is : ".$totalPercent;
            $status = 'Congratulations you passed the quiz';
        }

        return view('quiz.pages.end-quiz-ques',compact('quiz','testAverage','scored','status'));
    }
}
