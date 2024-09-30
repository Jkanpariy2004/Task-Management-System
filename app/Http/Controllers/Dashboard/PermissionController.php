<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PermissionController extends Controller
{
    public function index(){
        return view('Dashboard.Permission.Permission');
    }

    public function fetch(){
        $permissions = Permission::all();

        return response()->json([
            'permissions' => $permissions,
        ]);
    }

    public function add(){
        return view('Dashboard.Permission.Add-Permission');
    }

    public function insert(Request $request) {
        $validator = Validator::make($request->all(), [
            'permission_name' => 'required',
            'permission_slug' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        Permission::create([
            'permission_name' => $request->permission_name,
            'slug' => $request->permission_slug
        ]);

        return response()->json(['message' => 'Permission created successfully!'], 200);
    }

    public function delete($id)
    {
        $permission = Permission::find($id);
        if ($permission) {
            $permission->delete();
            return response()->json(['status' => 'success', 'message' => 'Permission deleted successfully.']);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Permission not found.'], 404);
        }
    }
}
