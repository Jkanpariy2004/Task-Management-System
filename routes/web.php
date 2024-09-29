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

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// // // // // // // //
// User Panel Route  //
// // // // // // // //

Route::prefix('user')->group(function () {

    Route::controller(UserLogin::class)->group(function () {
        Route::get('/', 'index')->name('user.login');
        Route::post('/login', 'Userlogin')->name('user.login.check');
        Route::get('/logout', 'UserLogout')->name('user.logout');
    });

    Route::middleware('auth.user')->group(function () {

        Route::controller(Home::class)->group(function () {
            Route::get('/dashboard', 'index');
            Route::get('/Fetch-User-Task', 'FetchUserTask');
        });

        Route::post('/comments-store', [Comment::class, 'store'])->name('comments.store');
    });
});

// // // // // // // //
// Admin Panel Route //
// // // // // // // //
Route::prefix('admin')->group(function () {
    Route::controller(Login::class)->group(function () {
        Route::get('/', 'showLoginForm')->name('admin.login');
        Route::post('/login', 'login')->name('admin.login.check');
        Route::get('/logout', 'logout')->name('admin.logout');
    });

    Route::get('users/password-creation-form', [Users::class, 'showPasswordCreationForm'])->name('password.creation.form');
    Route::post('users/password-creation', [Users::class, 'store']);

    Route::middleware('auth.admin')->group(function () {
        Route::get('/dashboard', [Index::class, 'index']);

        Route::prefix('users')->controller(Users::class)->group(function () {
            Route::get('/', 'index')->name('users');
            Route::get('/add', 'AddUsers');
            Route::post('/submit', 'SubmitUser');
            Route::get('/fetch-users', 'FetchUsers');
            Route::get('/delete/{id}', 'UsersDelete')->name('users.delete');
            Route::get('/edit/{id}', 'edit');
            Route::post('/update/{id}', 'UserUpdate')->name('users.update');
            Route::post('/send-invitation', 'sendInvitation');
            // Route::get('/password-creation-form', 'showPasswordCreationForm')->name('password.creation.form');
            // Route::post('/password-creation', 'store');
            Route::post('/bulk-delete', 'bulkDelete')->name('bulk.delete.user');
        });

        Route::prefix('cache')->controller(CacheClear::class)->group(function () {
            Route::get('/', 'index')->name('cache');
            Route::get('/cache-clear', 'clearCache')->name('cache.clear');
            Route::get('/route-cache-clear', 'clearRouteCache')->name('route.cache.clear');
            Route::get('/config-cache-clear', 'clearConfigCache')->name('config.cache.clear');
            Route::get('/view-cache-clear', 'clearViewCache')->name('view.cache.clear');
            Route::get('/compiled-cache-clear', 'clearCompiledCache')->name('compiled.cache.clear');
            Route::get('/optimize-cache-clear', 'optimizeCache')->name('optimize.cache.clear');
        });

        Route::prefix('company')->controller(Company::class)->group(function () {
            Route::get('/', 'index')->name('company');
            Route::get('/fetch-company', 'FetchCompany');
            Route::get('/add', 'AddCompany');
            Route::post('/submit', 'SubmitCompany')->name('submit.company');
            Route::get('/edit/{id}', 'edit');
            Route::post('/update/{id}', 'CompanyUpdate')->name('company.update');
            Route::get('/delete/{id}', 'CompanyDelete')->name('company.delete');
            Route::post('/bulk-delete', 'bulkDelete')->name('bulk.delete.company');
        });

        Route::prefix('task')->controller(Task::class)->group(function () {
            Route::get('/', 'index')->name('task');
            Route::get('/fetch-task', 'FetchTask')->name('fetch.task');
            Route::get('/add', 'AddTask')->name('add.task');
            Route::post('/submit', 'SubmitTask')->name('submit.task');
            Route::get('/delete/{id}', 'TaskDelete')->name('task.delete');
            Route::post('/bulk-delete', 'bulkDelete')->name('bulk.delete.task');
            Route::get('/edit/{id}', 'edit');
            Route::post('/update/{id}', 'TaskUpdate')->name('task.update');
            Route::post('/store-comments', 'store_comment')->name('store.comments');
        });
    });
});
