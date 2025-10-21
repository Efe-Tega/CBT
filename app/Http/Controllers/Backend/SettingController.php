<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\AcademicTerm;
use App\Models\AcademicYear;
use App\Models\Exam;
use App\Models\ExamSetting;
use App\Models\School;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function settings()
    {
        return view('backend.settings');
    }

    public function addAcademicYear(Request $request)
    {
        $request->validate(['year' => 'required']);

        AcademicYear::insert([
            'name' => str_replace(' ', '', $request->year),
            'created_at' => Carbon::now(),
        ]);

        $notification = array(
            'message' => 'Session Added',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }

    public function examConfig()
    {
        $terms = AcademicTerm::all();
        $sessions = AcademicYear::all();
        $exam_types = Exam::all();
        $config = ExamSetting::find(1);
        return view('backend.settings.exam-config', compact('terms', 'sessions', 'exam_types', 'config'));
    }

    public function updateTerm(Request $request)
    {
        ExamSetting::updateOrCreate(
            ['id' => 1],
            ['academic_term_id' => $request->current_term,]
        );

        $notification = array(
            'message' => 'Settings Updated!',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }

    public function updateCurrentSession(Request $request)
    {
        ExamSetting::updateOrCreate(
            ['id' => 1],
            ['academic_year_id' => $request->current_session,]
        );

        $notification = array(
            'message' => 'Settings Updated!',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }

    public function assessmentType(Request $request)
    {
        ExamSetting::updateOrCreate(
            ['id' => 1],
            ['exam_id' => $request->exam_type,]
        );

        $notification = array(
            'message' => 'Settings Updated!',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }
}
