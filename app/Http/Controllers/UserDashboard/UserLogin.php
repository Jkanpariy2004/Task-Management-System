<?php

namespace App\Http\Controllers\UserDashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Users;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class UserLogin extends Controller
{
    public function index(){
        return view('UserDashboard.Login.Login');
    }

    public function UserLoginCheck(Request $request)
    {
        $message = [
            'email.required' => 'Please Enter Valid User Email Id.',
            'password.required' => 'Please Enter Valid User Password.',
            'password.min' => 'Please Enter Minimum 6 digits Password.',
        ];

        $request->validate([
            'email' => 'required',
            'password' => 'required|min:6',
        ], $message);

        $email = $request->input('email');
        $password = $request->input('password');

        $user = Users::where('email', $email)->first();

        if ($user && Hash::check($password, $user->password)) {
            Session::put('email', $email);
            return response()->json(['success' => 'Login Successful. Redirecting....'], 200);
        }

        return response()->json(['errors' => 'Please Enter Valid email or password.'], 400);
    }

    public function UserLogout(){
        Session::flush();

        return redirect('/user')->with('success', 'Logout Successfully.');
    }
}
