<?php

namespace App\Http\Controllers\UserDashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Task as dbtask;

class Home extends Controller
{
    public function index(){
        return view('UserDashboard.User-Dashboard');
    }

    public function FetchUserTask()
    {
        $tasks = dbtask::all();

        return response()->json([
            'tasks' => $tasks,
        ]);
    }
}
