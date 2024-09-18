<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Login\Login;
use App\Http\Controllers\Dashboard\Index;
use App\Http\Controllers\Dashboard\Users;
use App\Http\Controllers\CacheClear;

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

// Route::get('/', function () {
//     return view('welcome');
// });

// login Route
Route::get('/',[Login::class,'index']);
Route::post('Check-Login',[Login::class,'LoginCheck']);

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
