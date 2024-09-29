<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Mail\InvitationMail;
use App\Models\Users as dbusers;
use App\Models\Company as dbcompany;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;


class Users extends Controller
{
    public function index()
    {
        // if (!Session::has('adminemail')) {
        //     return redirect('/admin')->with('error', 'Please login to access this page.');
        // }

        return view('Dashboard.Users');
    }

    public function AddUsers()
    {
        // if (!Session::has('adminemail')) {
        //     return redirect('/admin')->with('error', 'Please login to access this page.');
        // }

        $companys = dbcompany::all();
        return view('Dashboard.Add-Users',compact('companys'));
    }

    public function FetchUsers()
    {
        // $users = dbusers::all();
        $users = DB::table('user')
            ->leftJoin('company', 'user.company', '=', 'company.id')
            ->select('user.*', 'company.c_name')
            ->get();
        return response()->json([
            'users' => $users,
        ]);
    }

    public function SubmitUser(Request $request)
    {
        $message = [
            'name.required' => 'Please Enter User Name.',
            'email.required' => 'Please Enter User Email.,',
            'mobile.required' => 'Please Enter User Mobile.',
            'mobile.digits' => 'Please Enter Valid 10 digits Mobile No.',
            'designation.required' => 'Please Enter User designation.',
            'joining_date.required' => 'Please Enter User Joining Date.',
            'birth_date.required' => 'Please Enter User Birth date.',
            'company.required' => 'Please Select User Company Name.',
        ];

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'mobile' => 'required|digits:10',
            'designation' => 'required',
            'joining_date' => 'required',
            'birth_date' => 'required',
            'company' => 'required',
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
        $user->company = $request->input('company');

        $user->save();

        return response()->json(['message' => 'User created successfully!'], 200);
    }

    public function UserUpdate(Request $request, $id)
    {
        $message = [
            'name.required' => 'Please Enter User Name.',
            'email.required' => 'Please Enter User Email.,',
            'mobile.required' => 'Please Enter User Mobile.',
            'mobile.digits' => 'Please Enter Valid 10 digits Mobile No.',
            'designation.required' => 'Please Enter User designation.',
            'joining_date.required' => 'Please Enter User Joining Date.',
            'birth_date.required' => 'Please Enter User Birth date.',
            'company.required' => 'Please Select User Company Name.',
        ];

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'mobile' => 'required|digits:10',
            'designation' => 'required',
            'joining_date' => 'required',
            'birth_date' => 'required',
            'company' => 'required',
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
        // if (!Session::has('adminemail')) {
        //     return redirect('/admin')->with('error', 'Please login to access this page.');
        // }

        $companys = dbcompany::all();
        $show = dbusers::all();
        $new = dbusers::find($id);
        $url = url('/admin/users/update/' . $id);
        $com = compact('show', 'new', 'url','companys');
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
        $token = Str::random(60);

        $user = dbusers::where('email', $request->email)->first();

        if (!$user) {
            return response()->json(['error' => 'Email not found in the database.'], 404);
        }

        $user->token = $token;
        $user->save();
        $passwordCreationUrl = url('/admin/users/password-creation-form?token='.$token);

        Mail::to($request->email)->send(new InvitationMail($recipientEmail, $passwordCreationUrl));

        return response()->json(['success' => 'Email sent successfully.']);
    }

    public function showPasswordCreationForm(Request $request)
    {
        $user = $request->query('user');
        $token = $request->query('token');

        return view('Dashboard.PasswordCreationForm', compact('user','token'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'password' => 'required|min:6',
            'confirmPassword' => 'required|same:password',
            'token' => 'required'
        ]);

        $token = $request->input('token');
        $user = dbusers::where('token', $token)->first();

        if (!$user) {
            return response()->json(['error' => 'Token is Expired. User not found.'], 404);
        }

        $user->password = bcrypt($request->input('password'));
        $user->token = NULL;
        $user->save();

        return response()->json(['success' => 'Password Created successfully!']);
    }
}
