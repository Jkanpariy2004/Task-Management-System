<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\Login\Login;
use App\Http\Controllers\Dashboard\Index;
use App\Http\Controllers\Dashboard\Users;
use App\Http\Controllers\Dashboard\Company;
use App\Http\Controllers\Dashboard\Task;
use App\Http\Controllers\CacheClear;
use App\Http\Controllers\UserDashboard\Login\UserLogin;
use App\Http\Controllers\UserDashboard\Home;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// // // // // // // //
// User Panel Route  //
// // // // // // // //

// Login Page
Route::get('/user',[UserLogin::class,'index']);
Route::post('User-Login',[UserLogin::class,'UserLoginCheck']);
Route::get('/UserLogout',[UserLogin::class,'UserLogout']);

// Home Page
Route::get('/user-dashboard',[Home::class,'index']);
Route::get('/Fetch-User-Task',[Home::class,'FetchUserTask']);

// // // // // // // //
// Admin Panel Route //
// // // // // // // //

// login Route
Route::get('/admin',[Login::class,'index']);
Route::post('Check-Login',[Login::class,'LoginCheck']);
Route::get('/logout',[Login::class,'logout']);

// Dashboard Route
Route::get('/dashboard',[Index::class,'index']);

// users Route
Route::get('/users',[Users::class,'index']);
Route::get('/add-users',[Users::class,'AddUsers']);
Route::post('/Submit-Post',[Users::class,'SubmitUser']);
Route::get('/fetch-users',[Users::class,'FetchUsers']);
Route::get('/users-delete/{id}',[Users::class,'UsersDelete'])->name('users.delete');
Route::get('/users-edit/{id}',[Users::class,'edit']);
Route::post('/users-update/{id}',[Users::class,'UserUpdate'])->name('users.update');
Route::post('/send-invitation', [Users::class, 'sendInvitation']);
Route::get('/password-creation-form', [Users::class, 'showPasswordCreationForm'])->name('password.creation.form');
// Route::get('/password-creation-form/{username}', [Users::class, 'showPasswordCreationForm'])->name('password.creation.form');
Route::post('/password-creation', [Users::class, 'store']);
Route::post('/bulk-delete-users', [Users::class, 'bulkDelete']);

// cache clear
Route::get('/Cache-Setting',[CacheClear::class,'index']);
Route::get('/cache-clear', [CacheClear::class, 'clearCache'])->name('cache.clear');
Route::get('/route-cache-clear', [CacheClear::class, 'clearRouteCache'])->name('route.cache.clear');
Route::get('/config-cache-clear', [CacheClear::class, 'clearConfigCache'])->name('config.cache.clear');
Route::get('/view-cache-clear', [CacheClear::class, 'clearViewCache'])->name('view.cache.clear');
Route::get('/compiled-cache-clear', [CacheClear::class, 'clearCompiledCache'])->name('compiled.cache.clear');
Route::get('/optimize-cache-clear', [CacheClear::class, 'optimizeCache'])->name('optimize.cache.clear');

// Company Route
Route::get('/company',[Company::class,'index']);
Route::get('/fetch-company',[Company::class,'FetchCompany']);
Route::get('/add-company',[Company::class,'AddCompany']);
Route::post('/Submit-Company',[Company::class,'SubmitCompany']);
Route::get('/company-delete/{id}',[Company::class,'CompanyDelete'])->name('company.delete');
Route::post('/bulk-delete-company', [Company::class, 'bulkDelete']);
Route::get('/company-edit/{id}',[Company::class,'edit']);
Route::post('/company-update/{id}',[Company::class,'CompanyUpdate'])->name('company.update');

// Task Route
Route::get('/task',[Task::class,'index']);
Route::get('/fetch-task',[Task::class,'FetchTask']);
Route::get('/add-task',[Task::class,'AddTask']);
Route::post('/Submit-Task',[Task::class,'SubmitTask']);
Route::get('/task-delete/{id}',[Task::class,'TaskDelete'])->name('task.delete');
Route::post('/bulk-delete-task', [Task::class, 'bulkDelete']);
Route::get('/task-edit/{id}',[Task::class,'edit']);
Route::post('/task-update/{id}',[Task::class,'TaskUpdate'])->name('task.update');