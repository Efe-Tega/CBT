<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class StudentManagement extends Controller
{
    public function studentPerformance()
    {
        return view('backend.students.academic-performance');
    }

    public function studentEnrollment()
    {
        return view('backend.students.student-enrollment');
    }
}
