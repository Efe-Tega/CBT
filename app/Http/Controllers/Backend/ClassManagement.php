<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ClassManagement extends Controller
{
    public function viewClasses()
    {
        return view('backend.school-classes.index');
    }
}
