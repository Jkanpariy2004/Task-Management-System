<?php

namespace App\Http\Middleware\Dashboard;

use App\Models\user_permission;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ManagePermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::guard('web')->user();

        if (!$user) {
            return redirect()->back()->with('error', 'User Not Found');
        }

        $roleId = $user->role;
        $url = $request->route()->getName();

        $permission = user_permission::where('role_id', $roleId)
            ->whereHas('permission', function ($query) use ($url) {
                $query->where('permission_name', $url);
            })->first();

        // Check if permission exists
        if (!$permission) {
            return redirect()->back()->with('error', 'Unauthorized Access');
        }

        $canAccess = false;

        // Check for list permission
        if ($permission->list == 1) {
            $canAccess = true;
        }

        if ($url == $url) {
            $canAccess = $canAccess || ($permission->create == 1);
        } elseif ($url == 'edit') {
            $canAccess = $canAccess || ($permission->update == 1);
        } elseif ($url == 'delete') {
            $canAccess = $canAccess || ($permission->delete == 1);
        }

        if (!$canAccess) {
            return redirect()->back()->with('error', 'Unauthorized Permission');
        }

        return $next($request);
    }
}
