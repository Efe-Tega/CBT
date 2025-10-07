<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ManagementLoginController extends Controller
{
    public function managementLogin(){
        if (Auth::guard('admin')->check() || Auth::guard('teacher')->check()){
            return redirect()->route('management.dashboard');
        }

        return view('auth.management-login');
    }

    public function managementAccess(Request $request){
        // $request->validate([
        //     'email' => 'required|email',
        //     'password' => 'required',
        // ]);

        $credentials = $request->only('email', 'password');

        // Admin
        if (Auth::guard('admin')->attempt($credentials)){
            $this->logActivity('admin', Auth::guard('admin')->id(), $request, 'login');
            return redirect()->route('management.dashboard');
        }

        // Teacher
        if (Auth::guard('teacher')->attempt($credentials)){
            $this->logActivity('teacher', Auth::guard('teacher')->id(), $request, 'login');
            return redirect()->route('management.dashboard');
        }

        return back()->with(['error' => 'Incorrect email or password']);

    }

    public function managementLogout(Request $request){
        if(Auth::guard('admin')->check()){
            $this->logActivity('admin', Auth::guard('admin')->id(), $request, 'logout');
            Auth::guard('admin')->logout();
        } elseif (Auth::guard('teacher')->check()){
            $this->logActivity('teacher', Auth::guard('teacher')->id(), $request, 'logout');
            Auth::guard('teacher')->logout();
        }

        return redirect()->route('management.login');
    }

    private function logActivity($guard, $id, Request $request, $action){
        AuditLog::create([
            'guard' => $guard,
            'user_id' => $id,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'action' => $action,
        ]);
    }
}
