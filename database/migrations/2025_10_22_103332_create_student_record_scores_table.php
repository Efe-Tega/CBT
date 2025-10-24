<?php

use App\Models\Subject;
use App\Models\User;
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
        Schema::create('student_record_scores', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class);
            $table->foreignIdFor(Subject::class);
            $table->integer('class_id')->nullable();
            $table->integer('exam_id')->nullable();
            $table->integer('term_id')->nullable();
            $table->integer('year_id')->nullable();
            $table->integer('total_questions')->nullable();
            $table->integer('correct_answer')->nullable();
            $table->decimal('score_percentage', 5, 2)->nullable();
            // $table->integer('graded_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_record_scores');
    }
};
