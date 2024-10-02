<?php

namespace App\Http\Middleware\Dashboard;

use App\Models\Permission;
use App\Models\user_permission;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ManagePermission
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::guard('admin')->user();

        if (!$user) {
            return redirect()->back()->with('error', 'Unauthorized Access');
        }

        $roleId = $user->role;
        $url = $request->route()->getName();
        // dd($url);
        // $url = basename($url);

        $permission = user_permission::where('role_id', $roleId)
            ->whereHas('permission', function ($query) use ($url) {
                $query->where('permission_name', $url); 
            })->first();
        
        if (!$permission) {
            return redirect()->back()->with('error', 'Unauthorized Access');
        }

        $canAccess = false;

        if ($url == $url) {
            $canAccess = $permission->list == 1;
        } elseif ($url == 'add') {
            $canAccess = $permission->create == 1;
        } elseif ($url == 'edit') {
            $canAccess = $permission->update == 1;
        } elseif ($url == 'delete') {
            $canAccess = $permission->delete == 1;
        } else {
            return redirect()->back()->with('error', 'Invalid Permission Request');
        }

        if (!$canAccess) {
            return redirect()->back()->with('error', 'Unauthorized Permission');
        }

        return $next($request);
    }
}
