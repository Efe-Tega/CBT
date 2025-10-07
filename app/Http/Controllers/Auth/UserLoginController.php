<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserLoginController extends Controller
{
    public function Login(){
        if(Auth::check()){
            return redirect()->route('user.dashboard');
        };

        return view('auth.user-login');
    }

    public function userLogin(Request $request){
        $credentials = $request->only('lastname', 'password');

        if (Auth::guard('web')->attempt($credentials)){
            return redirect()->route('user.dashboard');
        }

        return back()->withErrors(['lastname' => 'Invalid credentials']);
    }

}
