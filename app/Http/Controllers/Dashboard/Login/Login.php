<?php

namespace App\Http\Controllers\Dashboard\Login;

use App\Http\Controllers\Controller;
use App\Models\admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class Login extends Controller
{
    public function showLoginForm()
    {
        return view('Dashboard.Login.Login');
    }

    public function login(Request $request)
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

        if (Auth::guard('admin')->attempt($credentials)) {
            return response()->json(['success' => 'Login Successful. Redirecting....'], 200);
        }

        return response()->json(['errors' => 'Please Enter Valid email or password.'], 400);
    }

    public function logout()
    {
        Auth::guard('admin')->logout(); // Log the user out

        return redirect('/admin')->with('success', 'Logout Successfully.');
    }
}
