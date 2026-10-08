<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('quizzes')) {
            Schema::create('quizzes', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('instructor_id')->nullable()->index();
                $table->unsignedBigInteger('program_id')->nullable()->index();
                $table->string('title');
                $table->text('description')->nullable();
                $table->string('status')->default('published')->index();
                $table->string('type')->default('Postest');
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('quiz_questions')) {
            Schema::create('quiz_questions', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('quiz_id')->index();
                $table->text('question');
                $table->string('type');
                $table->json('options')->nullable();
                $table->text('correct_answer')->nullable();
                $table->integer('points')->default(10);
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('quiz_responses')) {
            Schema::create('quiz_responses', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('quiz_id')->index();
                $table->unsignedBigInteger('quiz_question_id')->nullable()->index();
                $table->unsignedBigInteger('student_id')->index();
                $table->text('answer')->nullable();
                $table->boolean('is_correct')->default(false);
                $table->integer('score')->default(0);
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quiz_responses');
        Schema::dropIfExists('quiz_questions');
        Schema::dropIfExists('quizzes');
    }
};
