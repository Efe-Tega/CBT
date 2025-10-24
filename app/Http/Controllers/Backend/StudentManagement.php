<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\AcademicTerm;
use App\Models\AcademicYear;
use App\Models\Exam;
use App\Models\ExamSetting;
use App\Models\Question;
use App\Models\School;
use App\Models\SchoolClass;
use App\Models\StudentAnswer;
use App\Models\StudentRecordScore;
use App\Models\Subject;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class StudentManagement extends Controller
{
    public function studentPerformance(Request $request)
    {
        $classes = SchoolClass::all();
        $terms = AcademicTerm::all();
        $years = AcademicYear::all();
        $exams = Exam::all();
        $examInfo = ExamSetting::find(1);

        // Defaults
        $classId = $request->class_id ?? 0;
        $term = $request->term_id ?? null;
        $year = $request->academic_year ?? null;
        $exam = $request->exam_id ?? null;

        $subjects = collect();
        $records = collect();

        // If filters are applied
        if ($classId && $term && $year && $exam) {
            $subjects = Subject::where('class_id', $classId)->get();

            $records = StudentRecordScore::with(['user', 'subject'])
                ->where('class_id', $classId)
                ->where('term_id', $term)
                ->where('year_id', $year)
                ->where('exam_id', $exam)
                ->get();
        }

        return view('backend.students.academic-performance', compact(
            'terms',
            'years',
            'exams',
            'classes',
            'classId',
            'subjects',
            'records',
            'examInfo',
        ));
    }

    public function exportScores(Request $request)
    {
        $classId = $request->class_id;
        $term = $request->term_id;
        $year = $request->academic_year;
        $exam = $request->exam_id;

        $subjects = Subject::where('class_id', $classId)->get();
        $records = StudentRecordScore::where('class_id', $classId)
            ->where('term_id', $term)
            ->where('year_id', $year)
            ->where('exam_id', $exam)
            ->get()
            ->groupBy('user_id');

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Title
        $sheet->setCellValue('A1', 'Student Result Report');
        $sheet->mergeCells('A1:H1');
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // Header
        $header = ['S/N', 'Surname', 'First Name', 'Middle Name'];
        foreach ($subjects as $subject) {
            $header[] = $subject->name;
        }
        $header[] = 'Total';
        $sheet->fromArray($header, null, 'A3');

        // Style header
        $sheet->getStyle('A3:' . $sheet->getHighestColumn() . '3')->applyFromArray([
            'font' => ['bold' => true],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => 'D9E1F2'],
            ],
            'borders' => [
                'allBorders' => ['borderStyle' => Border::BORDER_THIN],
            ],
        ]);

        // Data rows
        $row = 4;
        $count = 1;
        foreach ($records as $studentRecords) {
            $student = $studentRecords->first()->user ?? null;
            if (!$student) continue;

            $dataRow = [
                $count,
                $student->lastname ?? '',
                $student->firstname ?? '',
                $student->middlename ?? ''
            ];

            $totalCorrect = 0;
            $totalQuestions = 0;

            foreach ($subjects as $subject) {
                $record = $studentRecords->where('subject_id', $subject->id)->first();
                $correct = $record->correct_answer ?? 0;
                $questions = $record->total_questions ?? 0;
                $totalCorrect += $correct;
                $totalQuestions += $questions;
                $dataRow[] = $correct;
            }

            $dataRow[] = $totalCorrect;
            $sheet->fromArray($dataRow, null, 'A' . $row);

            $row++;
            $count++;
        }

        // Auto-size columns
        foreach (range('A', $sheet->getHighestColumn()) as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        // Save and download
        $className = SchoolClass::find($classId);
        $examType = Exam::find($exam);
        $schoolTerm = AcademicTerm::find($term);

        $filename = $className->name . '_student_' . $schoolTerm->name . '_' . $examType->title . '_report.xlsx';
        $writer = new Xlsx($spreadsheet);
        $filePath = storage_path($filename);
        $writer->save($filePath);

        return response()->download($filePath)->deleteFileAfterSend(true);
    }


    public function getSubjects($class_id)
    {
        $subjects = Subject::where('class_id', $class_id)->get();
        return response()->json($subjects);
    }

    public function studentEnrollment()
    {
        $classes = SchoolClass::all();
        $schools = School::all();
        return view('backend.students.student-enrollment', compact('classes', 'schools'));
    }

    public function registerStudent(Request $request)
    {
        $request->validate([
            'firstname' => 'required|string|max:255|min:3',
            'lastname' => 'required|string|max:255|min:3',
            'school_class' => 'required',
            'school_id' => 'required'
        ], [
            'firstname.required' => 'Please enter student first name',
            'lastname.required' => 'Student surname is required',
            'school_class.required' => 'Please select a class',
            'school_id.required' => 'Please select a school',
        ]);

        User::create([
            'firstname' => $request->firstname,
            'middlename' => $request->middlename,
            'lastname' => $request->lastname,
            'class_id' => $request->school_class,
            'school_id' => $request->school_id,
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
        $schools = School::all();

        return view('backend.students.student-list', compact('students', 'class', 'classLevels', 'schools'));
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
            'school_id' => $request->school_id,
            'password' => Hash::make($request->lastname),
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
