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
        Schema::create('quiz_answereds', function (Blueprint $table) {
            $table->id();
            $table->index('quiz_attempt_id');
            $table->foreignId('quiz_attempt_id')->references('id')->on('quiz_attempts')->onDelete('cascade');
            $table->index('quiz_question_id');
            $table->foreignId('quiz_question_id')->references('id')->on('quiz_questions')->onDelete('cascade');
            $table->text('quiz_answered');
            $table->boolean('is_skipped')->default(0);
            $table->boolean('is_false')->default(0);
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
        Schema::dropIfExists('quiz_answereds');
    }
};
