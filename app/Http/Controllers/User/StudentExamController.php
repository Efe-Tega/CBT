<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\ExamSession;
use App\Models\Question;
use App\Models\StudentAnswer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
            'exam_id' => $request->exam_id,
            'question_id' => $questionId,
        ], [
            'selected_answer' => $answer,
            'is_correct' => $is_correct,
        ]);

        return response()->json(['success' => true]);
    }

    public function finalizeExam(Request $request)
    {
        $user = Auth::user();
        $studentId = $user->id;

        StudentAnswer::where('user_id', $studentId)
            ->where('exam_id', $request->exam_id)
            ->update(['finalized' => true]);

        ExamSession::where('user_id', $user->id)->update(['status' => 'completed']);

        Auth::logout();

        return redirect('/login')->with('status', 'Exam submitted successfully.');
    }

    public function getProgress($examId)
    {
        try {
            $user = Auth::user();
            $studentId = $user->id;

            $answers = StudentAnswer::where('user_id', $studentId)
                ->where('exam_id', $examId)->get(['question_id', 'selected_answer']);

            return response()->json([
                'answers' => $answers,
            ]);
        } catch (\Throwable $e) {
            // return full debug info to find the problem
            return response()->json([
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ], 500);
        }
    }

    public function examSummary()
    {
        $user = Auth::user();
        $studentAnswers = StudentAnswer::where('user_id', $user->id)
            ->where('finalized', false)->get();

        $examId = $studentAnswers->first()?->exam_id;
        return view('user.summary', compact('studentAnswers', 'examId'));
    }
}
