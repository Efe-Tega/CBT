<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\SchoolClass;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ClassManagement extends Controller
{
    public function viewClasses()
    {
        $classLevels = SchoolClass::oldest()->get();
        return view('backend.school-classes.index', ['classes' => $classLevels]);
    }

    public function addClass(Request $request)
    {
        $request->validate([
            'school_class' => 'required|string',
        ]);

        $classLevel = $request->school_class;
        $formattedLevel = strtoupper(preg_replace('/\s+/', '', $classLevel));

        $is_existing = SchoolClass::where('name', $formattedLevel)->first();
        if ($is_existing) {
            return redirect()->back()->with('error', 'Class already exist');
        } else {
            SchoolClass::insert([
                'name' => $formattedLevel,
                'created_at' => Carbon::now(),
            ]);

            return redirect()->back()->with('success', 'Class added');
        }
    }

    public function updateClass(Request $request)
    {
        $request->validate(['school_class' => 'required|string']);
        $class = SchoolClass::findOrFail($request->id);
        $class->update(['name' => $request->school_class]);

        return back()->with('info', 'Class updated successfully!');
    }
}
