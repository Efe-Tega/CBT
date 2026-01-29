<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\ExamSetting;
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
        $config = ExamSetting::find(1);

        return view('backend.questions.index', compact('subjectsByClass', 'subjects', 'config'));
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
        $instructions = Instruction::where('subject_id', $id)->get();

        return view('backend.questions.questions-page', [
            'questions' => $questions,
            'subject' => $subject,
            'instructions' => $instructions,
        ]);
    }

    public function addQuestions(Request $request, $id)
    {
        $subject = Subject::find($id);
        $instructions = Instruction::where('subject_id', $id)->get();
        $questions = Question::where('subject_id', $id)->get();
        $totalQues = count($questions);

        return view('backend.questions.add-question', compact('subject', 'instructions', 'totalQues'));
    }

    public function storeQuestion(Request $request)
    {
        $request->validate([
            'option_a' => 'required|string',
            'option_b' => 'required|string',
            'correct_answer' => 'required|string',
            'instruction_id' => 'nullable|exists:instructions,id',
            'instruction_text' => 'nullable|string',
            'marks' => 'required',
        ]);

        try {
            $instructionId = null;

            if (!empty($request->instruction_text)) {
                $instruction = Instruction::create([
                    'subject_id' => $request->subject_id,
                    'text' => $request->instruction_text,
                ]);
                $instructionId = $instruction->id;
            } elseif (!empty($request->instruction_id)) {
                $instructionId = $request->instruction_id;
            };

            Question::create([
                'subject_id' => $request->subject_id,
                'instruction_id' => $instructionId,
                'question_text' => $request->question_text,
                'option_a' => $request->option_a,
                'option_b' => $request->option_b,
                'option_c' => $request->option_c,
                'option_d' => $request->option_d,
                'option_e' => $request->option_e,
                'correct_answer' => $request->correct_answer,
                'is_visible' => true,
                'marks' => $request->marks,
                'created_at' => Carbon::now(),
            ]);

            $notification = array(
                'message' => 'Question added',
                'alert-type' => 'success'
            );

            return redirect()->back()->with($notification);
        } catch (\Exception $e) {
            return redirect()->back()->with([
                'message' => 'Something went wrong!',
                'alert-type' => 'error',
            ]);
        }
    }

    public function editQuestion(Request $request, $id)
    {
        $question = Question::find($id);
        return view('backend.questions.edit-question', compact('question',));
    }

    public function updateQuestion(Request $request)
    {
        $id = $request->quesiton_id;

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
            'option_e' => $request->option_e,
            'marks' => $request->marks,
            'correct_answer' => $request->correct_answer,
        ]);

        $notification = array(
            'message' => 'Question updated successfully!',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }

    public function deleteQuestion($id)
    {
        Question::find($id)->delete();
        return redirect()->back();
    }

    public function bulkDelete(Request $request)
    {
        if (!$request->ids || count($request->ids) === 0) {
            return response()->json([
                'success' => false,
                'message' => 'No questions selected'
            ]);
        }

        Question::whereIn('id', $request->ids)->delete();

        return response()->json([
            'success' => true,
            'message' => 'Selected questions deleted'
        ]);
    }
}
