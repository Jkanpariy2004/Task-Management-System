<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\Role;
use App\Models\user_permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RolesController extends Controller
{
    public function index()
    {
        $permissions = Permission::orderBy('id')->get();
        $roleId = Role::all();
        $userPermissions = [];

        foreach($roleId as $id) {
            $rolePermissions = user_permission::where('role_id', $id->id)->get()->keyBy('permission_id');

            foreach ($permissions as $permission) {
                if ($rolePermissions->has($permission->id)) {
                    $userPermissions[$permission->id] = [
                        'list' => $rolePermissions[$permission->id]->list,
                        'create' => $rolePermissions[$permission->id]->create,
                        'update' => $rolePermissions[$permission->id]->update,
                        'delete' => $rolePermissions[$permission->id]->delete,
                    ];
                } else {
                    $userPermissions[$permission->id] = [
                        'list' => false,
                        'create' => false,
                        'update' => false,
                        'delete' => false,
                    ];
                }
            }
        }

        return view('Dashboard.Roles.Role', compact('permissions', 'userPermissions'));
    }

    public function fetch() {
        $roles = Role::all();

        return response()->json([
            'roles' => $roles
        ]);
    }

    public function assignPermission(Request $request) {
        $role = Role::findOrFail($request->role_id);
        $role->permissions()->attach($request->permission_id);

        return response()->json(['message' => 'Permission assigned successfully']);
    }

    public function revokePermission(Request $request) {
        $role = Role::findOrFail($request->role_id);
        $role->permissions()->detach($request->permission_id);

        return response()->json(['message' => 'Permission revoked successfully']);
    }


    public function add(){
        return view('Dashboard.Roles.Add-Role');
    }

    public function insert(Request $request){
        $validator = Validator::make($request->all(), [
            'role_name' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        Role::create([
            'role_name' => $request->role_name
        ]);

        return response()->json(['message' => 'Role created successfully!'], 200);
    }

    public function update(Request $request, $id){
        $validator = Validator::make($request->all(), [
            'role_name' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $role = Role::find($id);
        $role->role_name = $request->role_name;

        $role->save();

        return response()->json(['message' => 'Role Updated successfully!'], 200);
    }

    public function edit($id)
    {
        $show = Role::all();
        $new = Role::find($id);
        $com = compact('show', 'new');
        return view('Dashboard.Roles.Role_edit', $com);
    }

    public function delete($id)
    {
        $role = Role::find($id);
        if ($role) {
            $role->delete();
            return response()->json(['status' => 'success', 'message' => 'Role deleted successfully.']);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Role not found.'], 404);
        }
    }

    public function permissionAssign(Request $request)
    {
        $LoginUser = auth()->guard('admin')->user()->id;

        $roleId = $request->role_id;

        foreach ($request->permissions as $permissionId => $permissions) {
            $permissionData = user_permission::where('role_id', $roleId)
                ->where('permission_id', $permissionId)
                ->first();

            $data = [
                'role_id' => $roleId,
                'permission_id' => $permissionId,
                'list' => isset($permissions['list']),
                'create' => isset($permissions['create']),
                'update' => isset($permissions['update']),
                'delete' => isset($permissions['delete']),
                'created_updated_by' => $LoginUser,
            ];

            if ($permissionData) {
                $permissionData->update($data);
            } else {
                user_permission::create($data);
            }
        }

        return redirect()->back()->with('success', 'Permissions assigned successfully.');
    }

}
