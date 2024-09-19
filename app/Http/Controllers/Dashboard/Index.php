<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class Index extends Controller
{
    public function index(){
        if (!Session::has('email')) {
            return redirect('/admin')->with('error', 'Please login to access this page.');
        }
        
        return view('Dashboard.Index');
    }
}
