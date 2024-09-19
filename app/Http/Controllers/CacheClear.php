<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Session;

class CacheClear extends Controller
{
    public function index(){
        if (!Session::has('email')) {
            return redirect('/admin')->with('error', 'Please login to access this page.');
        }
        
        return view('Dashboard.cache');
    }
    public function clearCache()
    {
        Artisan::call('cache:clear');
        return response()->json(['success' => 'Cache cleared successfully!']);
    }

    public function clearRouteCache()
    {
        Artisan::call('route:clear');
        return response()->json(['success' => 'Route cache cleared successfully!']);
    }

    public function clearConfigCache()
    {
        Artisan::call('config:clear');
        return response()->json(['success' => 'Config cache cleared successfully!']);
    }

    public function clearViewCache()
    {
        Artisan::call('view:clear');
        return response()->json(['success' => 'View cache cleared successfully!']);
    }

    public function clearCompiledCache()
    {
        Artisan::call('clear-compiled');
        return response()->json(['success' => 'Compiled File cache cleared successfully!']);
    }

    public function optimizeCache()
    {
        Artisan::call('optimize');
        return response()->json(['success' => 'Optimized Cache Cleared successfully!']);
    }
}
