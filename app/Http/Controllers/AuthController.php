<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login_process(Request $request)
    {
        if(Auth::guard('employee')->attempt(['employee_id'=> $request->employee_id, 'password' => $request->password])) {
            return redirect('/dashboard');
        } else {
            return redirect('/')->with(['warning' => 'Invalid Employee ID or Password']);
        }

    }

    public function logout_process()
    {
        if(Auth::guard('employee')->check()) {
            Auth::guard('employee')->logout();
            return redirect('/');
        } else {
            echo "Logout failed";
        }
    }
}
