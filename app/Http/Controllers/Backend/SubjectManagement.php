<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\School;
use App\Models\SchoolClass;
use App\Models\Subject;
use App\Models\Teacher;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SubjectManagement extends Controller
{
    public function viewSubjects()
    {
        $schools = School::with('subjects')->get();
        $classes = SchoolClass::all();
        $teachers = Teacher::all();
        return view('backend.subjects.index', compact('schools', 'classes', 'teachers'));
    }

    public function addSubject(Request $request)
    {
        $request->validate([
            'subject' => 'required|string|max:255',
            'school_class' => 'required',
            'school' => 'required',
            'duration' => 'required',
            'teacher' => 'required',
        ], [
            'subject.required' => 'Enter a subject',
            'school_class.required' => 'Select a class from the dropdown',
            'school' => 'School cannot be left empty',
            'duration' => 'Please choose a subject duration',
            'teacher' => 'Assign a teacher',
        ]);

        Subject::insert([
            'class_id' => $request->school_class,
            'school_id' => $request->school,
            'teacher_id' => $request->teacher,
            'name' => $request->subject,
            'duration' => $request->duration,
            'created_at' => Carbon::now(),
        ]);

        return redirect()->back()->with('success', 'Subject added successfully');
    }
}
