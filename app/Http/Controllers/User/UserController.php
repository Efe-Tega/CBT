<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Exam;
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
        $exam = Exam::where('status', 'active')->firstOrFail();
        $questions = Question::where('exam_id', $exam->id)
            ->where('subject_id', $subj_id)
            ->where('is_visible', true)
            ->inRandomOrder()
            ->get();

        return view('user.questions', compact('questions', 'exam'));
    }

    public function userLogout()
    {
        Auth::guard('web')->logout();
        return redirect()->route('login');
    }
}
