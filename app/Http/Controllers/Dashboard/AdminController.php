<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\admin;
use App\Models\Role;
use App\Mail\AdminInvitationMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;

class AdminController extends Controller
{
    public function index()
    {
        return view('Dashboard.admins.admins');
    }

    public function fetch()
    {
        $admins = admin::all();

        return response()->json([
            'admins' => $admins
        ]);
    }

    public function add()
    {
        $roles = Role::all();
        return view('Dashboard.admins.Add-admins', compact('roles'));
    }

    public function insert(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'admin_name' => 'required',
            'admin_email' => 'required',
            'admin_role' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $admin = new admin();
        $admin->name = $request->admin_name;
        $admin->email = $request->admin_email;
        $admin->role = $request->admin_role;

        $admin->save();

        return response()->json(['message' => 'Admin created successfully!'], 200);
    }

    public function edit($id)
    {
        $roles = Role::all();
        $show = admin::all();
        $new = admin::find($id);
        $com = compact('show', 'new', 'roles');
        return view('Dashboard.admins.admins_edit', $com);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'admin_name' => 'required',
            'admin_email' => 'required|email',
            'admin_role' => 'required'
        ], [
            'admin_name.required' => 'The admin name is mandatory.',
            'admin_email.required' => 'The email address is mandatory.',
            'admin_email.email' => 'Please enter a valid email address.',
            'admin_role.required' => 'Please select an admin role.'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $admin = admin::find($id);
        $admin->name = $request->admin_name;
        $admin->email = $request->admin_email;
        $admin->role = $request->admin_role;

        $admin->save();

        return response()->json(['message' => 'Admin Updated successfully!'], 200);
    }

    public function sendInvitation(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $recipientEmail = $request->email;
        $username = $recipientEmail;
        // $username = urlencode($recipientEmail);
        $token = Str::random(60);

        $user = admin::where('email', $request->email)->first();

        if (!$user) {
            return response()->json(['error' => 'Email not found in the database.'], 404);
        }

        $user->token = $token;
        $user->save();
        $passwordCreationUrl = url('admin/admins/password-creation-form?token=' . $token);

        Mail::to($request->email)->send(new AdminInvitationMail($recipientEmail, $passwordCreationUrl));

        return response()->json(['success' => 'Email sent successfully.']);
    }

    public function showPasswordCreationForm(Request $request)
    {
        $user = $request->query('user');
        $token = $request->query('token');

        return view('Dashboard.Emails.AdminPasswordCreationForm', compact('user', 'token'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'password' => 'required|min:6',
            'confirmPassword' => 'required|same:password',
            'token' => 'required'
        ]);

        $token = $request->input('token');
        $user = admin::where('token', $token)->first();
        // $user = admin::where('token', $token)->update(['password' => bcrypt($request->input('password')), 'token' => null]);

        if (!$user) {
            return response()->json(['error' => 'Token is Expired. User not found.'], 404);
        }

        $user->password = bcrypt($request->input('password'));
        $user->token = NULL;
        $user->save();

        return response()->json(['success' => 'Password Created successfully!']);
    }
}
