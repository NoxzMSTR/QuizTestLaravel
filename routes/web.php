<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\QuizController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [DashboardController::class,'index'])->name('dashboard');
Route::get('/{quiz}/start-quiz', [DashboardController::class,'startQuiz'])->middleware(['auth'])->name('startQuiz');


Route::get('/{quiz}/attempt-quiz', [QuizController::class,'quizAttemptView'])->middleware(['auth'])->name('quizAttempt');
Route::post('/{quiz}/attempt-quiz', [QuizController::class,'addAttemptedQuizQues'])->middleware(['auth'])->name('saveAttemptedQuizQues');

Route::get('/{quiz}/view-quiz-review', [QuizController::class,'viewQuizReview'])->middleware(['auth'])->name('viewReview');

Route::get('/view-quiz', [QuizController::class,'quizView'])->name('viewQuiz');
Route::post('/add-quiz', [QuizController::class,'addQuiz'])->name('addQuiz');

Route::get('/{quiz}/view-quiz-question', [QuizController::class,'viewQuizQues'])->name('viewQuizQuestions');
Route::post('/{quiz}/view-quiz-question', [QuizController::class,'addQuizQues'])->name('addQuizQuestions');

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';
