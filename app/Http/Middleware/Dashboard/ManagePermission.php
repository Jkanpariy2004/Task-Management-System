<?php

namespace App\Http\Middleware\Dashboard;

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
        $action = $request->route()->getName();

        if (!$action) {
            return redirect()->back()->with('error', 'Route name not found');
        }

        dd('Action Name: ' . $action);

        $permission = user_permission::where('role_id', $roleId)
            ->whereHas('permission', function ($query) use ($action) {
                $query->where('permission_name', $action);
            })
            ->first();

        if (!$permission) {
            return redirect()->back()->with('error', 'Unauthorized Access');
        }

        if (($permission->list === false && ($action !== 'add' && $action !== 'update' && $action !== 'delete')) ||
            ($action === 'add' && !$permission->create) ||
            ($action === 'update' && !$permission->update) ||
            ($action === 'delete' && !$permission->delete)) {
            return redirect()->back()->with('error', 'Unauthorized Permission');
        }

        return $next($request);
    }

}
