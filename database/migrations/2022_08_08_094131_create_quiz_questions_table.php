<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quiz_questions', function (Blueprint $table) {
            $table->id();
            $table->index('quiz_id');
            $table->foreignId('quiz_id')->references('id')->on('quizzes')->onDelete('cascade');
            $table->enum('type',['single','multiple']);
            $table->text('quiz_question');
            $table->text('quiz_answer');
            $table->text('quiz_correct_answer');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('quiz_questions');
    }
};
