<?php

namespace App\Http\Controllers\Dashboard\Login;

use App\Http\Controllers\Controller;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('Dashboard.Login.Login');
    }
}
