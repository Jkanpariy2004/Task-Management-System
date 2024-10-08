<?php

namespace App\Http\Controllers\UserDashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Task as dbtask;
use App\Models\Assign_Task as dbassign_task;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        $AuthUser = Auth::guard('user')->user();
        $userEmail = $AuthUser->email;

        $userData = DB::table('user')
            ->where('email', $userEmail)
            ->first();

        if ($userData) {
            $user = DB::table('user')
                ->leftJoin('company', 'user.company', '=', 'company.id')
                ->select('user.*', 'company.c_name')
                ->where('user.id', $userData->id)
                ->first();
        } else {
            return redirect()->route('user.login')->with('error', 'User not logged in.');
        }

        $UserId = $userData->id;
        $UserTaskData = dbassign_task::where('user_id', $UserId)->pluck('task_id');

        $TaskData = dbtask::whereIn('id', $UserTaskData)->get()->map(function ($task) {
            $task->attachments = json_decode($task->attechments);
            return $task;
        });

        $TaskDate = dbtask::whereIn('id', $UserTaskData)->first();

        $date = \Carbon\Carbon::now()->format('d-m-Y');

        $todayTask = $TaskData->where('due_date', '==', $date);
        $todayTasksCount = $todayTask->count();

        $dueTasks = $TaskData->where('due_date', '<', $date)->whereNotNull('due_date');
        $dueTasksCount = $dueTasks->count();

        $NextTasks = $TaskData->filter(function ($task) use ($date) {
            return $task->start_date > $date || $task->due_date > $date;
        });
        $NextTasksCount = $NextTasks->count();

        $UnscheduledTask = $TaskData->filter(function ($task) use ($date) {
            return ($task->start_date == null && $task->due_date == null);
        });
        $UnscheduledCount = $UnscheduledTask->count();
        $users = DB::table('comments')
            ->leftJoin('user', 'comments.user_id', '=', 'user.id')
            ->select('comments.*', 'user.name')
            ->first();

        $comments = DB::table('comments')->orderBy('created_at', 'asc')->get();

        $data = compact('userData', 'UserId', 'UserTaskData', 'TaskData', 'user', 'TaskDate', 'date', 'todayTask', 'todayTasksCount', 'dueTasks', 'dueTasksCount', 'NextTasks', 'NextTasksCount', 'UnscheduledTask', 'UnscheduledCount', 'users', 'comments');

        return view('UserDashboard.Home.User-Dashboard', $data);
    }


    public function FetchUserTask()
    {
        $tasks = dbtask::all();

        return response()->json([
            'tasks' => $tasks,
        ]);
    }
}
