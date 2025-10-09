<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\Subject;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function dashboard()
    {
        $subjects = Subject::latest()->get();
        return view('user.dashboard', compact('subjects'));
    }

    public function userQuestions($id)
    {
        $exam = Exam::where('subject_id', $id)->firstOrFail();
        $questions = $exam->questions;

        return view('user.questions', compact('questions'));
    }
}
