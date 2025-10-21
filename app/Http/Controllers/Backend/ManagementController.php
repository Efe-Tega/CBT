<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\ExamSetting;
use App\Models\Question;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ManagementController extends Controller
{
    public function dashboard()
    {
        if (Auth::guard('teacher')->check()) {
            $config = ExamSetting::find(1);
            $teacher = Auth::guard('teacher')->user();
            $totalQuestions = Question::join('subjects', 'questions.subject_id', '=', 'subjects.id')
                ->where('subjects.teacher_id', $teacher->id)->count();

            $totalSubjects = Subject::where('teacher_id', $teacher->id)->distinct('name')->count('name');

            $totalClass = Subject::where('teacher_id', $teacher->id)->count();

            $totalUsers = 0;
            $totalTeachers = 0;
        } elseif (Auth::guard('admin')->check()) {
            $config = ExamSetting::find(1);
            $totalUsers = User::count();
            $totalSubjects = Subject::distinct('name')->count('name');
            $totalQuestions = Question::count();
            $totalTeachers = Teacher::count();

            $totalClass = 0;
        }

        return view('backend.index', [
            'config' => $config,
            'students' => $totalUsers,
            'uniqueSubjects' => $totalSubjects,
            'questions' => $totalQuestions,
            'teachers' => $totalTeachers,
            'classes' => $totalClass,
        ]);
    }
}
