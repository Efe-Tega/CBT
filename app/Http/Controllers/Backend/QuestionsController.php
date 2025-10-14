<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class QuestionsController extends Controller
{
    public function manageQuestions()
    {
        return view('backend.questions.index');
    }
}
