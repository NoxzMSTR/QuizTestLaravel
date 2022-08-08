<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\QuizAnswered;
use Illuminate\Http\Request;
use App\Models\QuizQuestions;
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
        'duration' => 'required|date_format:H:i:s',
       ]);
       
       Quiz::create([
        'title' => $request->title,
        'duration' => $request->duration,
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

    public function quizAttemptView(Quiz $quiz)
    {
        return view('quiz.pages.start-quiz-ques',compact('quiz'));
    }
    public function addAttemptedQuizQues(Request $request,Quiz $quiz)
    {
       $validate = $request->validate([
        'ques' => 'required|array',
        'single' => 'required|array',
        'multi' => 'required|array'
       ]);
       $check = '';
       $data = '';
       foreach ($request->ques as $key => $value) {
            $quizQ = $quiz->quizQues()->where('id',$value)->first();
            if ($quizQ->type == 'multiple') {
                $data = implode(',',$request->multi[$value]);
                $quizQ->quiz_correct_answer == implode(',',$request->multi[$value]) ? $check = false : $check = true;
            }else{
                $data = $request->single[$value];
                $quizQ->quiz_correct_answer == $request->single[$value] ? $check = false : $check = true;
            }
            QuizAnswered::create([
                'user_id' => Auth::user()->id,
                'quiz_question_id' => $value,
                'quiz_answered' => $data,
                'is_false' => $check,
            ]);
       }
       return Response::json([
        'message' => 'Quiz Submitted Successfully.'
       ],200);
    }
}
