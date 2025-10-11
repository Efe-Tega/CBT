<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\Question;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function dashboard()
    {
        $student = Auth::user();
        $subjects = Subject::where('class_id', $student->id)->latest()->get();
        return view('user.dashboard', compact('subjects', 'student'));
    }

    public function userQuestions($id)
    {
        $exam = Exam::where('status', 'active')->firstOrFail();
        $questions = Question::where('exam_id', $exam->id)
            ->where('is_visible', true)
            ->inRandomOrder()
            ->get();

        return view('user.questions', compact('questions'));
    }

    public function userLogout()
    {
        Auth::guard('web')->logout();
        return redirect()->route('login');
    }
}
