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
use App\Http\Controllers\UserDashboard\Comment;

// // // // // // // //
// User Panel Routes //
// // // // // // // //
Route::prefix('user')->group(function () {
    Route::controller(UserLogin::class)->group(function () {
        Route::get('/', 'index');
        Route::post('login', 'UserLoginCheck');
        Route::get('logout', 'UserLogout');
    });

    Route::controller(Home::class)->group(function () {
        Route::get('dashboard', 'index');
        Route::get('fetch-user-task', 'FetchUserTask');
    });
});

Route::controller(Comment::class)->group(function () {
    Route::post('/comments-store', 'store')->name('comments.store');
    Route::delete('/comments/{id}/delete', 'destroy');
});

// // // // // // //  //
// Admin Panel Routes //
// // // // // // //  //
Route::prefix('admin')->group(function () {
    Route::controller(Login::class)->group(function () {
        Route::get('/', 'index');
        Route::post('check-login', 'LoginCheck');
        Route::get('logout', 'logout');
    });

    Route::controller(Index::class)->group(function () {
        Route::get('dashboard', 'index');
    });

    Route::prefix('users')->controller(Users::class)->group(function () {
        Route::get('/', 'index');
        Route::get('add', 'AddUsers');
        Route::post('submit', 'SubmitUser');
        Route::get('fetch', 'FetchUsers');
        Route::get('delete/{id}', 'UsersDelete')->name('users.delete');
        Route::get('edit/{id}', 'edit');
        Route::post('update/{id}', 'UserUpdate')->name('users.update');
        Route::post('send-invitation', 'sendInvitation');
        Route::get('password-creation-form', 'showPasswordCreationForm')->name('password.creation.form');
        Route::post('password-creation', 'store');
        Route::post('bulk-delete', 'bulkDelete');
    });

    Route::prefix('company')->controller(Company::class)->group(function () {
        Route::get('/', 'index');
        Route::get('fetch', 'FetchCompany');
        Route::get('add', 'AddCompany');
        Route::post('submit', 'SubmitCompany');
        Route::get('delete/{id}', 'CompanyDelete')->name('company.delete');
        Route::post('bulk-delete', 'bulkDelete');
        Route::get('edit/{id}', 'edit');
        Route::post('update/{id}', 'CompanyUpdate')->name('company.update');
    });

    Route::prefix('task')->controller(Task::class)->group(function () {
        Route::get('/', 'index');
        Route::get('fetch', 'FetchTask');
        Route::get('add', 'AddTask');
        Route::post('submit', 'SubmitTask');
        Route::get('delete/{id}', 'TaskDelete')->name('task.delete');
        Route::post('bulk-delete', 'bulkDelete');
        Route::get('edit/{id}', 'edit');
        Route::post('update/{id}', 'TaskUpdate')->name('task.update');
        Route::post('store-comments', 'store_comment')->name('store.comments');
    });
});

Route::prefix('cache')->controller(CacheClear::class)->group(function () {
    Route::get('setting', 'index');
    Route::get('clear', 'clearCache')->name('cache.clear');
    Route::get('route-clear', 'clearRouteCache')->name('route.cache.clear');
    Route::get('config-clear', 'clearConfigCache')->name('config.cache.clear');
    Route::get('view-clear', 'clearViewCache')->name('view.cache.clear');
    Route::get('compiled-clear', 'clearCompiledCache')->name('compiled.cache.clear');
    Route::get('optimize-clear', 'optimizeCache')->name('optimize.cache.clear');
});
