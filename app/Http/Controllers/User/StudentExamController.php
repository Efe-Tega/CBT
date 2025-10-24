<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\ExamSession;
use App\Models\ExamSetting;
use App\Models\Question;
use App\Models\StudentAnswer;
use App\Models\StudentRecordScore;
use App\Models\Subject;
use Carbon\Carbon;
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
        $classId = $user->class_id;
        $examId = $request->exam_id;

        $examInfo = ExamSetting::find(1);

        StudentAnswer::where('user_id', $studentId)
            ->where('exam_id', $examId)
            ->update(['finalized' => true]);

        $finalizedAnswer = StudentAnswer::where('user_id', $studentId)
            ->where('exam_id', $examId)
            ->where('finalized', true)
            ->with('question')
            ->first();

        if (!$finalizedAnswer || !$finalizedAnswer->question) {
            return back()->with('error', 'No finalized answers found.');
        }

        $subjectId = $finalizedAnswer->question->subject_id;


        $totalQuestions = Question::where('subject_id', $subjectId)
            ->where('is_visible', true)
            ->count();

        $totalCorrectAnswers = StudentAnswer::where('user_id', $studentId)
            ->where('exam_id', $examId)
            ->where('finalized', true)
            ->where('is_correct', 1)
            ->count();


        // 5️⃣ Optionally calculate percentage or score
        // $percentage = $totalQuestions > 0 ? ($totalCorrectAnswers / $totalQuestions) * 100 : 0;
        $record = StudentRecordScore::create([
            'user_id' => $studentId,
            'subject_id' => $subjectId,
            'class_id' => $classId,
            'exam_id' => $examId,
            'term_id' => $examInfo->academic_term_id,
            'year_id' => $examInfo->academic_year_id,
            'total_questions' => $totalQuestions,
            'correct_answer' => $totalCorrectAnswers,
            'created_at' => Carbon::now(),
        ]);

        if ($record) {
            StudentAnswer::where('user_id', $studentId)
                ->where('exam_id', $examId)
                ->delete();
        }

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

    public function examSummary(Request $request)
    {
        $user = Auth::user();
        $studentAnswers = StudentAnswer::where('user_id', $user->id)
            ->where('finalized', false)->get();

        $subjectId = $request->query('subject_id');
        $subject = Subject::findOrFail($subjectId);

        $examId = $studentAnswers->first()?->exam_id;
        return view('user.summary', compact('studentAnswers', 'examId', 'subject'));
    }
}
