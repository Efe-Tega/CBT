<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Question;
use App\Models\StudentAnswer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentExamController extends Controller
{
    public function saveAnswer(Request $request)
    {
        $user = Auth::user();
        $studentId = $user->id;

        $questionId = $request->question_id;
        $answer = $request->answer;

        $question = Question::find($questionId);
        $is_correct = $answer === $question->correct_answer;

        StudentAnswer::updateOrCreate([
            'user_id' => $studentId,
            'question_id' => $questionId,
        ], [
            'selected_answer' => $answer,
            'is_correct' => $is_correct,
        ]);

        return response()->json(['success' => true]);
    }
}
