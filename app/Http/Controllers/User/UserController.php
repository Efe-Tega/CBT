<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\ExamSession;
use App\Models\Question;
use App\Models\StudentAnswer;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function dashboard()
    {
        $student = Auth::user();
        $subjects = Subject::where('class_id', $student->class_id)
            ->where('status', 'active')
            ->latest()
            ->get();

        $finalizedSubjectIds = StudentAnswer::where('user_id', $student->id)
            ->where('finalized', true)
            ->join('questions', 'student_answers.question_id', '=', 'questions.id')
            ->pluck('questions.subject_id')
            ->unique()
            ->toArray();

        return view('user.dashboard', compact('subjects', 'student', 'finalizedSubjectIds'));
    }

    public function userQuestions($subj_id)
    {
        $student = Auth::user();
        $subject = Subject::findOrFail($subj_id);

        $exam = Exam::where('status', 'active')->firstOrFail(); // returns active CA or Exam
        $questions = Question::with('instruction')
            ->where('subject_id', $subj_id)
            ->where('is_visible', true)
            ->inRandomOrder()
            ->get();

        $existingSession = ExamSession::where('user_id', $student->id)
            ->where('subject_id', $subj_id)
            ->where('status', 'in_progress')
            ->first();

        if (!$existingSession) {
            $startTime = now();
            $endTime = now()->addMinutes($subject->duration);

            $existingSession = ExamSession::create([
                'user_id' => $student->id,
                'subject_id' => $subj_id,
                'start_time' => $startTime,
                'end_time' => $endTime,
                'status' => 'in_progress',
            ]);
        }

        return view('user.questions', [
            'questions' => $questions,
            'exam' => $exam,
            'session' => $existingSession,
            'subjectName' => $subject->name,
        ]);
    }

    public function userLogout()
    {
        Auth::guard('web')->logout();
        return redirect()->route('login');
    }
}
