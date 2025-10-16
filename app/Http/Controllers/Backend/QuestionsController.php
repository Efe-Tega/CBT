<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\Question;
use App\Models\Subject;
use Carbon\Carbon;
use Illuminate\Http\Request;

class QuestionsController extends Controller
{
    public function manageQuestions()
    {
        $subjectsByClass = Subject::with('class')->get()->groupBy('class_id');

        return view('backend.questions.index', compact('subjectsByClass'));
    }

    public function toggleStatus($id)
    {
        $subject = Subject::findOrFail($id);
        $subject->status = $subject->status === 'active' ? 'inactive' : 'active';
        $subject->save();

        return response()->json([
            'success' => true,
            'status' => $subject->status,
        ]);
    }

    public function questionsPage($id)
    {
        $subject = Subject::find($id);
        $questions = Question::where('subject_id', $id)->get();
        $exam = Exam::where('status', 'active')->first();

        return view('backend.questions.questions-page', [
            'questions' => $questions,
            'subject' => $subject,
            'exam' => $exam,
        ]);
    }

    public function storeQuestion(Request $request)
    {
        $request->validate([
            'question_text' => 'required|string',
            'option_a' => 'required|string',
            'option_b' => 'required|string',
            'correct_answer' => 'required|string',
        ], [
            'question_text.required' => 'Question field cannot be left empty. Enter question',
        ]);

        $question = Question::insert([
            'exam_id' => $request->exam_id,
            'subject_id' => $request->subject_id,
            'question_text' => $request->question_text,
            'option_a' => $request->option_a,
            'option_b' => $request->option_b,
            'option_c' => $request->option_c,
            'option_d' => $request->option_d,
            'correct_answer' => $request->correct_answer,
            'is_visible' => true,
            'created_at' => Carbon::now(),
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Question added successfully',
            'data' => $question
        ]);
    }
}
