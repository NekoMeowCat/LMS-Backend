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
        Schema::create('assessments', function (Blueprint $table) {
            // Might need a better name for this table. 
            $table->id();
            $table->foreignId('subject_educator_id')->constrained()->onDelete('cascade');
            $table->string('name')->nullable(); //or title
            $table->enum('type', ['quiz', 'exam'])->default('quiz');
            $table->json('questions');
            /**
             * [
             *   {
             *     "question": "What is the capital of France?",
             *     "options": ["Berlin", "Madrid", "Paris", "Rome"],
             *     "answer": "Paris"
             *   },
             *   {
             *     "question": "What is 2 + 2?",
             *     "options": ["3", "4", "5", "6"],
             *     "answer": "4"
             *   }
             * ]
             */
            $table->timestamps();
        });

        Schema::create('assessment_answers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('assessment_id')->constrained()->onDelete('cascade');
            $table->foreignId('student_id')->constrained('users')->onDelete('cascade');
            $table->json('answers');
            /**
             * [
             *   {
             *     "question": "What is the capital of France?",
             *     "answer": "Paris"
             *   },
             *   {
             *     "question": "What is 2 + 2?",
             *     "answer": "4"
             *   }
             * ]
             */
            $table->integer('score')->nullable(); // Score can be calculated later
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assesments');
        Schema::dropIfExists('assessment_answers'); 
    }
};
