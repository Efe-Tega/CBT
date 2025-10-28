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
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ManagementController extends Controller
{
    public function dashboard()
    {
        if (Auth::guard('teacher')->check()) {
            $config = ExamSetting::find(1);
            $students = User::all();
            $teacher = Auth::guard('teacher')->user();
            $totalQuestions = Question::join('subjects', 'questions.subject_id', '=', 'subjects.id')
                ->where('subjects.teacher_id', $teacher->id)->count();

            $totalSubjects = Subject::where('teacher_id', $teacher->id)->distinct('name')->count('name');

            $totalClass = Subject::where('teacher_id', $teacher->id)->count();

            $totalUsers = 0;
            $totalTeachers = 0;
        } elseif (Auth::guard('admin')->check()) {
            $students = User::latest()->get();
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
            'all_students' => $students,
        ]);
    }

    public function exportAllStudent()
    {
        $students = User::all();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Title
        $sheet->setCellValue('A1', 'All Students');
        $sheet->mergeCells('A1:H1');
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // Header
        $header = ['S/N', 'Registration Number', 'Surname', 'First Name', 'Middle Name', 'Class Id'];
        $sheet->fromArray($header, null, 'A3');

        // Data Rows
        $row = 4;
        $count = 1;
        foreach ($students as $student) {
            if (!$student) continue;

            $dataRow = [
                $count,
                $student->registration_number ?? '',
                $student->lastname ?? '',
                $student->firstname ?? '',
                $student->middlename ?? '',
                $student->class_id ?? '',
            ];

            $sheet->fromArray($dataRow, null, 'A' . $row);

            $row++;
            $count++;
        }

        foreach (range('A', $sheet->getHighestColumn()) as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        $filename = 'All_Student.xlsx';
        $writer = new Xlsx($spreadsheet);
        $filePath = storage_path($filename);
        $writer->save($filePath);

        return response()->download($filePath)->deleteFileAfterSend(true);
    }
}
