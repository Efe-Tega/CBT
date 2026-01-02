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
        $subjectsByClass = Subject::with('class')->get()->groupBy('class_id');
        $classes = SchoolClass::all();
        $teachers = Teacher::all();
        return view('backend.subjects.index', compact('schools', 'classes', 'teachers', 'subjectsByClass'));
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

        $subjectName = ucwords($request->subject);
        $classId = $request->school_class;

        $exists = Subject::where('name', $subjectName)
            ->where('class_id', $classId)
            ->exists();

        if ($exists) {
            $notification = array(
                'message' => 'Subject already exists for selected class',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }

        Subject::insert([
            'class_id' => $classId,
            'school_id' => $request->school,
            'teacher_id' => $request->teacher,
            'name' => ucwords($request->subject),
            'duration' => $request->duration,
            'created_at' => Carbon::now(),
        ]);

        return redirect()->back()->with('success', 'Subject added successfully');
    }

    public function updateSchoolSubject(Request $request)
    {
        $id = $request->id;
        $subject_name = ucwords($request->subject);

        $subject = Subject::findOrFail($id);
        $exists = Subject::where('name', $subject_name)
            ->where('class_id', $request->class_id)
            ->where('id', '!=', $id)
            ->exists();

        if ($exists) {
            $notification = array('message' => 'The subject already exists for the selected class', 'alert-type' => 'warning');
            return redirect()->back()->with($notification);
        }

        $subject->update([
            'class_id' => $request->class_id,
            'school_id' => $request->school_id,
            'teacher_id' => $request->teacher_id,
            'name' => $subject_name,
            'duration' => $request->duration,
        ]);

        $notification = array('message' => 'Subject Data updated successfully', 'alert-type' => 'success');
        return redirect()->back()->with($notification);
    }

    public function deleteSubject($id)
    {
        Subject::findOrFail($id)->delete();
        return redirect()->back();
    }
}
