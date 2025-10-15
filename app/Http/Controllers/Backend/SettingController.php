<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\School;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function settings()
    {
        return view('backend.settings');
    }
}
