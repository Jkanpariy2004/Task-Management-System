<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\Users as dbusers;
use App\Models\Comment as dbcomment;
use App\Models\Task as dbtask;
use App\Models\Assign_Task as dbassign_task;

class Task extends Controller
{
    public function index(){
        // if (!Session::has('adminemail')) {
        //     return redirect('/admin')->with('error', 'Please login to access this page.');
        // }

        $comments = DB::table('comments')->orderBy('created_at', 'asc')->get();

        return view('Dashboard.Task', compact('comments'));
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
        // if (!Session::has('adminemail')) {
        //     return redirect('/admin')->with('error', 'Please login to access this page.');
        // }

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
            'priority' => 'required',
            'attechments' => 'required|array|max:30',
            'attechments.*' => 'mimes:jpeg,png,jpg,pdf|max:20480'
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

        if ($request->hasFile('attechments')) {
            $otherImages = $request->file('attechments');
            $imageNames = [];
            $errorMessages = [];

            $sanitizedTitle = preg_replace('/[^a-zA-Z0-9-_\.]/', '_', strtolower($task->title));

            foreach ($otherImages as $index => $image) {
                $imageNameOther = $sanitizedTitle . '_' . ($index + 1) . '.' . $image->getClientOriginalExtension();
                if ($image->isValid()) {
                    $image->move(public_path('assets/Task-Attechments'), $imageNameOther);
                    $imageNames[] = $imageNameOther;
                } else {
                    $errorMessages[] = "The attachment '{$imageNameOther}' failed to upload.";
                }
            }

            if (!empty($errorMessages)) {
                return response()->json(['errors' => $errorMessages], 422);
            }

            $task->attechments = json_encode($imageNames);
        }

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

    public function TaskUpdate(Request $request, $id)
    {
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
            'priority' => 'required',
            'attechments' => 'nullable|array|max:30',
            'attechments.*' => 'mimes:jpeg,png,jpg,pdf|max:20480',
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

        $existingAttachments = json_decode($task->attechments, true) ?? [];
        $removedAttachments = explode(',', $request->input('removed_attachments'));

        foreach ($removedAttachments as $attachment) {
            if (($key = array_search($attachment, $existingAttachments)) !== false) {
                unlink(public_path('assets/Task-Attechments/' . $attachment));
                unset($existingAttachments[$key]);
            }
        }

        $sanitizedTitle = preg_replace('/[^a-zA-Z0-9-_\.]/', '_', strtolower($task->title));

        if ($request->hasFile('attechments')) {
            $otherImages = $request->file('attechments');
            foreach ($otherImages as $index => $image) {
                $imageNameOther = $sanitizedTitle . '_' . ($index + 1) . '.' . $image->getClientOriginalExtension();
                if ($image->isValid()) {
                    $image->move(public_path('assets/Task-Attechments'), $imageNameOther);
                    $existingAttachments[] = $imageNameOther;
                }
            }
        }

        $task->attechments = json_encode(array_values($existingAttachments));

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

        return response()->json(['message' => 'Task Update failed!'], 500);
    }


    public function edit($id)
    {
        // if (!Session::has('adminemail')) {
        //     return redirect('/admin')->with('error', 'Please login to access this page.');
        // }

        $users = dbusers::all();
        $show = dbtask::all();
        $new = dbtask::find($id);

        $assignedTask = dbassign_task::where('task_id', $id)->first();
        $assignedUserId = $assignedTask ? $assignedTask->user_id : null;

        $existingAttachments = json_decode($new->attechments, true);

        $url = url('/users-update/' . $id);
        $com = compact('show', 'new', 'url', 'users', 'assignedUserId', 'existingAttachments');
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

    public function store_comment(Request $request)
    {
        $request->validate([
            'comment_text' => 'required|max:255',
            'post_id' => 'required|integer',
        ]);

        $FetchUser = Session::get('adminemail');

        if (!$FetchUser) {
            return response()->json([
                'success' => false,
                'message' => 'User not found in session.'
            ], 404);
        }

        $userData = DB::table('admin')->where('email', $FetchUser)->first();

        if (!$userData) {
            return response()->json([
                'success' => false,
                'message' => 'User data not found.'
            ], 404);
        }

        $comment = new dbcomment();
        $comment->user_id = $userData->name.'(admin)';
        $comment->comment_text = $request->comment_text;
        $comment->post_id = $request->post_id;
        $comment->save();

        return response()->json([
            'success' => true,
            'user' => $userData,
            'comment' => $comment
        ]);
    }
}
