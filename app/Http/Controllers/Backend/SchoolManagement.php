<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\School;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SchoolManagement extends Controller
{
    public function addSchool(Request $request)
    {
        $request->validate(['school' => 'required|string']);

        $schoolName = School::where('name', $request->school)->first();
        if ($schoolName) {
            return redirect()->back()->with('error', 'School name already exists!');
        } else {
            School::create([
                'name' => $request->school,
                'created_at' => Carbon::now(),
            ]);

            return redirect()->back()->with('success', 'School added successfully');
        }
    }
}
