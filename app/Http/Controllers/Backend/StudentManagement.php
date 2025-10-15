<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\SchoolClass;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class StudentManagement extends Controller
{
    public function studentPerformance()
    {
        return view('backend.students.academic-performance');
    }

    public function studentEnrollment()
    {
        $classes = SchoolClass::all();
        return view('backend.students.student-enrollment', compact('classes'));
    }

    public function registerStudent(Request $request)
    {
        $request->validate([
            'firstname' => 'required|string|max:255|min:3',
            'lastname' => 'required|string|max:255|min:3',
            'school_class' => 'required',
            'gender' => 'required',
        ], [
            'firstname.required' => 'Please enter student first name',
            'lastname.required' => 'Student surname is required',
            'school_class.required' => 'Please select a class',
            'gender.required' => 'Please select gender',
        ]);

        User::create([
            'firstname' => $request->firstname,
            'middlename' => $request->middlename,
            'lastname' => $request->lastname,
            'class_id' => $request->school_class,
            'gender' => $request->gender,
            'password' => Hash::make($request->lastname),
            'created_at' => Carbon::now(),
        ]);

        return redirect()->back()->with('info', 'Student Registered Successfully');
    }

    public function findStudent(Request $request)
    {
        $request->validate([
            'class_id' => 'required'
        ], [
            'class_id.required' => 'Select a class'
        ]);

        $classId = $request->class_id;
        $class = SchoolClass::findOrFail($classId);
        $students = User::where('class_id', $classId)->get();
        $classLevels = SchoolClass::all();

        return view('backend.students.student-list', compact('students', 'class', 'classLevels'));
    }

    public function updateStudentData(Request $request)
    {
        $student = User::findOrFail($request->id);

        $student->update([
            'firstname' => $request->firstname,
            'middlename' => $request->middlename,
            'lastname' => $request->lastname,
            'gender' => $request->gender,
            'class_id' => $request->school_class,
        ]);

        $student->refresh();

        return response()->json([
            'success' => true,
            'student' => $student
        ]);
    }

    public function deleteStudentData($id)
    {
        $student = User::findOrFail($id);

        if (!$student) {
            return response()->json(['success' => false, 'message' => 'Student not found']);
        }

        $student->delete();
        return response()->json(['success' => true]);
    }
}
