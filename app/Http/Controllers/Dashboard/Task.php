<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use App\Models\Users as dbusers;
use App\Models\Task as dbtask;
use App\Models\Assign_Task as dbassign_task;

class Task extends Controller
{
    public function index(){
        if (!Session::has('email')) {
            return redirect('/admin')->with('error', 'Please login to access this page.');
        }

        return view('Dashboard.Task');
    }

    public function FetchTask()
    {
        $tasks = dbtask::all();
        
        return response()->json([
            'tasks' => $tasks,
        ]);
    }
    
    public function AddTask()
    {
        if (!Session::has('email')) {
            return redirect('/admin')->with('error', 'Please login to access this page.');
        }
        
        $users = dbusers::all();
        return view('Dashboard.Add-Task',compact('users'));
    }

    public function SubmitTask(Request $request) {
        $message = [
            'task_title.required' => 'Please Enter Task Title.',
            'task_description.required' => 'Please Enter Task Description.',
            'start_date.required' => 'Please Select Task Start Date.',
            'due_date.required' => 'Please Select Task Due Date.',
            'assign.required' => 'Please Select Task Assign User.',
            'priority.required' => 'Please Select Task Priority.',
        ];
    
        $validator = Validator::make($request->all(), [
            'task_title' => 'required',
            'task_description' => 'required',
            'start_date' => 'nullable',
            'due_date' => 'nullable',
            'assign' => 'required',
            'priority' => 'required'
        ], $message);
    
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
    
        $task = new dbtask();
        $task->title = $request->input('task_title');
        $task->description = $request->input('task_description');
        $task->start_date = $request->input('start_date');
        $task->due_date = $request->input('due_date');
        $task->priority = $request->input('priority');
    
        if ($task->save()) {
            $assign_task = new dbassign_task();
            $assign_task->task_id = $task->id;
            $assign_task->user_id = $request->input('assign');
    
            if ($assign_task->save()) {
                return response()->json(['message' => 'Task created & assigned successfully!'], 200);
            } else {
                $task->delete(); 
                return response()->json(['message' => 'Task assignment failed!'], 500);
            }
        }
    
        return response()->json(['message' => 'Task creation failed!'], 500);
    }
        

    public function TaskUpdate(Request $request , $id){
        $message = [
            'task_title.required' => 'Please Enter Task Title.',
            'task_description.required' => 'Please Enter Task Description.,',
            'start_date.required' => 'Please Select Task Start Date.',
            'due_date.required' => 'Please Select Task Due Date.',
            'assign.required' => 'Please Select Task Assign User.',
            'priority.required' => 'Please Select Task Priority.',
        ];

        $validator = Validator::make($request->all(), [
            'task_title' => 'required',
            'task_description' => 'required',
            'start_date' => 'nullable',
            'due_date' => 'nullable',
            'assign' => 'required',
            'priority' => 'required',
        ], $message);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $task = dbtask::find($id);
        $task->title = $request->input('task_title');
        $task->description = $request->input('task_description');
        $task->start_date = $request->input('start_date');
        $task->due_date = $request->input('due_date');
        $task->priority = $request->input('priority');
    
        if ($task->save()) {
            $assign_task = dbassign_task::find($id);
            $assign_task->task_id = $task->id;
            $assign_task->user_id = $request->input('assign');
    
            if ($assign_task->save()) {
                return response()->json(['message' => 'Task Updated & assigned successfully!'], 200);
            } else {
                $task->delete(); 
                return response()->json(['message' => 'Task assignment failed!'], 500);
            }
        }

        return response()->json(['message' => 'Task creation failed!'], 500);
    }

    public function edit($id)
    {
        if (!Session::has('email')) {
            return redirect('/admin')->with('error', 'Please login to access this page.');
        }

        $users = dbusers::all();
        $show = dbtask::all();
        $new = dbtask::find($id);

        // Fetch the assigned task user ID
        $assignedTask = dbassign_task::where('task_id', $id)->first();
        $assignedUserId = $assignedTask ? $assignedTask->user_id : null;

        $url = url('/users-update/' . $id);
        $com = compact('show', 'new', 'url', 'users', 'assignedUserId');
        return view('Dashboard.Task_edit', $com);
    }

    public function TaskDelete($id)
    {
        $users = dbtask::find($id);
        if ($users) {
            $users->delete();
            return response()->json(['status' => 'success', 'message' => 'Task deleted successfully.']);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Task not found.'], 404);
        }
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->input('ids');
        if (!is_array($ids)) {
            return response()->json(['status' => 'error', 'message' => 'Invalid IDs'], 400);
        }
        $ids = array_filter($ids, 'is_numeric');
        dbtask::destroy($ids);
        return response()->json(['status' => 'success', 'message' => 'Tasks deleted successfully']);
    }
}
