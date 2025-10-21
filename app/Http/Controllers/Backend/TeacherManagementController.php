<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Teacher;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class TeacherManagementController extends Controller
{
    public function teachers()
    {
        $teachers = Teacher::all();
        return view('backend.teachers.index', compact('teachers'));
    }

    public function registerTeacher(Request $request)
    {
        $request->validate([
            'surname' => 'required|string',
            'othernames' => 'required|string',
            'email' => 'required|string'
        ], [
            'surname.required' => 'Surname is required',
            'othernames.required' => 'Please enter a name',
            'email.required' => 'Email Address is required'
        ]);

        Teacher::create([
            'name' => $request->surname . ' ' . $request->othernames,
            'email' => $request->email,
            'status' => 'active',
            'password' => Hash::make($request->surname),
            'created_at' => Carbon::now(),
        ]);

        return redirect()->back()->with("success", 'Teacher created successfully');
    }

    public function toggleTeachersStatus($id)
    {
        $teacher = Teacher::findOrFail($id);
        $teacher->status = $teacher->status === 'active' ? 'blocked' : 'active';
        $teacher->save();

        return response()->json([
            'success' => true,
            'status' => $teacher->status,
        ]);
    }

    public function updateTeacherData(Request $request)
    {
        $id = $request->id;

        Teacher::findOrFail($id)->update([
            'name' => $request->surname . ' ' . $request->othernames,
            'email' => $request->email,
            'password' => Hash::make($request->surname)
        ]);

        $notification = array(
            'message' => 'Data updated!',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }

    public function deleteTeacherData($id)
    {
        Teacher::findOrFail($id)->delete();
        return redirect()->back();
    }
}
