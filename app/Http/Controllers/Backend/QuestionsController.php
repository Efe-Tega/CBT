<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\Instruction;
use App\Models\Question;
use App\Models\Subject;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuestionsController extends Controller
{
    public function manageQuestions()
    {
        if (Auth::guard('teacher')->check()) {
            $teacher = Auth::guard('teacher')->user();

            // Only subjects that belong to this teacher
            $subjects = Subject::where('teacher_id', $teacher->id)
                ->with('class')
                ->get();
        } elseif (Auth::guard('admin')->check()) {
            // Admin sees all
            $subjects = Subject::with('class')->get();
        } else {
            abort(403, 'Unauthorized');
        }

        $subjectsByClass = Subject::with('class')->get()->groupBy('class_id');

        return view('backend.questions.index', compact('subjectsByClass', 'subjects'));
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

    public function toggleQuestionVisibility($id)
    {
        $question = Question::findOrFail($id);
        $question->is_visible = $question->is_visible === 1 ? false : true;
        $question->save();

        return response()->json([
            'success' => true,
            'status' => $question->is_visible,
        ]);
    }

    public function questionsPage($id)
    {
        $subject = Subject::find($id);
        $questions = Question::where('subject_id', $id)->get();
        $exam = Exam::where('status', 'active')->first();
        $instructions = Instruction::latest()->get();

        return view('backend.questions.questions-page', [
            'questions' => $questions,
            'subject' => $subject,
            'exam' => $exam,
            'instructions' => $instructions,
        ]);
    }

    public function storeQuestion(Request $request)
    {
        $request->validate([
            'option_a' => 'required|string',
            'option_b' => 'required|string',
            'correct_answer' => 'required|string',
            'instruction_id' => 'nullable|exists:instructions,id',
            'instruction_text' => 'nullable|string',
        ]);

        try {
            $instructionId = null;

            if (!empty($request->instruction_text)) {
                $instruction = Instruction::create([
                    'text' => $request->instruction_text,
                ]);
                $instructionId = $instruction->id;
            } elseif (!empty($request->instruction_id)) {
                $instructionId = $request->instruction_id;
            };

            $question = Question::create([
                'subject_id' => $request->subject_id,
                'instruction_id' => $instructionId,
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
                'data' => $question->load('instruction')
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong!',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function updateQuestion(Request $request, $id)
    {

        if ($request->filled('instruction_text')) {
            if ($request->filled('instruction_id')) {
                $instruction = Instruction::find($request->instruction_id);
                $instruction->update(['text' => $request->instruction_text]);
            } else {
                $instruction = Instruction::create([
                    'text' => $request->instruction_text,
                ]);
            }

            $instructionId = $instruction->id;
        } else {
            $instructionId = $request->instruction_id;
        }

        $question = Question::findOrFail($id);
        $question->update([
            'question_text' => $request->question_text,
            'instruction_id' => $instructionId,
            'option_a' => $request->option_a,
            'option_b' => $request->option_b,
            'option_c' => $request->option_c,
            'option_d' => $request->option_d,
            'correct_answer' => $request->correct_answer,
        ]);

        return response()->json([
            'message' => 'Question updated successfully!',
            'data' => $question->fresh()->load('instruction'),
        ]);
    }

    public function deleteQuestion($id)
    {
        Question::find($id)->delete();
        return redirect()->back();
    }
}
