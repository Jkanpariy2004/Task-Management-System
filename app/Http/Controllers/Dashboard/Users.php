<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Mail\InvitationMail;
use App\Models\Users as dbusers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;

class Users extends Controller
{
    public function index()
    {
        return view('Dashboard.Users');
    }

    public function AddUsers()
    {
        return view('Dashboard.Add-Users');
    }

    public function FetchUsers()
    {
        $users = dbusers::all();

        return response()->json([
            'users' => $users,
        ]);
    }

    public function SubmitUser(Request $request)
    {
        $message = [
            'name.required' => 'Please Enter User Name.',
            'email.required' => 'Please Enter User Name.,',
            'mobile.required' => 'Please Enter User Name.',
            'mobile.digits' => 'Please Enter Valid 10 digits Mobile No.',
            'designation.required' => 'Please Enter User Name.',
            'joining_date.required' => 'Please Enter User Name.',
            'birth_date.required' => 'Please Enter User Name.',
        ];

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'mobile' => 'required|digits:10',
            'designation' => 'required',
            'joining_date' => 'required',
            'birth_date' => 'required',
        ], $message);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user = new dbusers();
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->mobile = $request->input('mobile');
        $user->designation = $request->input('designation');
        $user->joining_date = $request->input('joining_date');
        $user->birth_date = $request->input('birth_date');

        $user->save();

        return response()->json(['message' => 'User created successfully!'], 200);
    }

    public function UserUpdate(Request $request, $id)
    {
        $message = [
            'name.required' => 'Please Enter User Name.',
            'email.required' => 'Please Enter User Name.,',
            'mobile.required' => 'Please Enter User Name.',
            'mobile.digits' => 'Please Enter Valid 10 digits Mobile No.',
            'designation.required' => 'Please Enter User Name.',
            'joining_date.required' => 'Please Enter User Name.',
            'birth_date.required' => 'Please Enter User Name.',
        ];

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'mobile' => 'required|digits:10',
            'designation' => 'required',
            'joining_date' => 'required',
            'birth_date' => 'required',
        ], $message);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user = dbusers::find($id);
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->mobile = $request->input('mobile');
        $user->designation = $request->input('designation');
        $user->joining_date = $request->input('joining_date');
        $user->birth_date = $request->input('birth_date');

        $user->save();

        return response()->json(['message' => 'User Updated successfully!'], 200);
    }

    public function edit($id)
    {
        $show = dbusers::all();
        $new = dbusers::find($id);
        $url = url('/users-update/' . $id);
        $com = compact('show', 'new', 'url');
        return view('Dashboard.User_edit', $com);
    }

    public function UsersDelete($id)
    {
        $users = dbusers::find($id);
        if ($users) {
            $users->delete();
            return response()->json(['status' => 'success', 'message' => 'User deleted successfully.']);
        } else {
            return response()->json(['status' => 'error', 'message' => 'User not found.'], 404);
        }
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->input('ids');
        if (!is_array($ids)) {
            return response()->json(['status' => 'error', 'message' => 'Invalid IDs'], 400);
        }
        $ids = array_filter($ids, 'is_numeric');
        dbusers::destroy($ids);
        return response()->json(['status' => 'success', 'message' => 'Posts deleted successfully']);
    }

    public function sendInvitation(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $recipientEmail = $request->email;
        $username = $recipientEmail;
        // $username = urlencode($recipientEmail);
        $passwordCreationUrl = url('/password-creation-form?user=' . $username);

        Mail::to($request->email)->send(new InvitationMail($recipientEmail, $passwordCreationUrl));
        Session::put('email', $username);

        return response()->json(['success' => 'Email sent successfully.']);
    }

    public function showPasswordCreationForm(Request $request)
    {
        $user = $request->query('user');
        return view('Dashboard.PasswordCreationForm', compact('user'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'password' => 'required|min:6',
            'confirm_password'=>'required|same:password'
        ]);

        $user = dbusers::where('email', Session::get('email'))->first();
        if (!$user) {
            return redirect()->back()->with('error', 'User not found.');
        }

        $user->password = bcrypt($request->input('password'));
        $user->save();
        Session::flush();
        return redirect()->back()->with('success', 'Password created successfully!');
    }
}
