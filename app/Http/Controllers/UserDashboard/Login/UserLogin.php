<?php

namespace App\Http\Controllers\UserDashboard\Login;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Users as dbuser;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class UserLogin extends Controller
{
    public function index()
    {
        return view('UserDashboard.Login.Login');
    }

    public function Userlogin(Request $request)
    {
        $message = [
            'email.required' => 'Please Enter Valid Email Id.',
            'password.required' => 'Please Enter Valid Password.',
            'password.min' => 'Please Enter Minimum 6 digits Password.',
        ];

        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ], $message);

        $credentials = $request->only('email', 'password');

        if (Auth::guard('user')->attempt($credentials)) {
            return response()->json(['success' => 'Login Successful. Redirecting....'], 200);
        }

        return response()->json(['errors' => 'Please Enter Valid email or password.'], 400);
    }

    public function UserLogout()
    {
        Auth::guard('user')->logout();
        
        return redirect('/user')->with('success', 'Logout Successfully.');
    }
}
