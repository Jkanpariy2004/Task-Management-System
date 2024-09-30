<?php

use App\Http\Controllers\Dashboard\AdminController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\Login\LoginController;
use App\Http\Controllers\Dashboard\IndexController;
use App\Http\Controllers\Dashboard\UsersController;
use App\Http\Controllers\Dashboard\CompanyController;
use App\Http\Controllers\Dashboard\TaskController;
use App\Http\Controllers\Dashboard\CacheClearController;
use App\Http\Controllers\Dashboard\PermissionController;
use App\Http\Controllers\Dashboard\RolesController;
use App\Http\Controllers\UserDashboard\Login\UserLoginController;
use App\Http\Controllers\UserDashboard\HomeController;
use App\Http\Controllers\UserDashboard\CommentController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// // // // // // // //
// User Panel Route  //
// // // // // // // //

Route::prefix('user')->group(function () {

    Route::controller(UserLoginController::class)->group(function () {
        Route::get('/', 'index')->name('user.login');
        Route::post('/login', 'Userlogin')->name('user.login.check');
        Route::get('/logout', 'UserLogout')->name('user.logout');
    });

    Route::middleware('auth.user')->group(function () {

        Route::controller(HomeController::class)->group(function () {
            Route::get('/dashboard', 'index');
            Route::get('/Fetch-User-Task', 'FetchUserTask');
        });

        Route::post('/comments-store', [CommentController::class, 'store'])->name('comments.store');
    });
});

// // // // // // // //
// Admin Panel Route //
// // // // // // // //
Route::prefix('admin')->group(function () {

    Route::get('admins/password-creation-form', [AdminController::class, 'showPasswordCreationForm'])->name('password.creation.form.admin');
    Route::post('admins/password-creation', [AdminController::class, 'store']);

    Route::prefix('admins')->controller(AdminController::class)->group(function () {
        Route::get('/', 'index')->name('admin.admins');
        Route::get('/fetch-admin', 'fetch')->name('fetch.admins');
        Route::get('/add', 'add')->name('add.admin');
        Route::post('/insert', 'insert')->name('insert.admins');
        Route::get('/edit/{id}', 'edit')->name('edit.admins');
        Route::post('/update/{id}', 'update')->name('update.admins');
        Route::get('/delete/{id}', 'delete')->name('delete.admins');
        Route::post('/send-invitation', 'sendInvitation');
    });
    
    Route::controller(LoginController::class)->group(function () {
        Route::get('/', 'showLoginForm')->name('admin.login');
        Route::post('/login', 'login')->name('admin.login.check');
        Route::get('/logout', 'logout')->name('admin.logout');
    });

    Route::middleware('auth.admin')->group(function () {
        Route::get('/dashboard', [IndexController::class, 'index']);

        Route::get('users/password-creation-form', [UsersController::class, 'showPasswordCreationForm'])->name('password.creation.form');
        Route::post('users/password-creation', [UsersController::class, 'store']);

        Route::prefix('users')->controller(UsersController::class)->group(function () {
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

        Route::post('/role/assign-permission', [RolesController::class, 'assignPermission'])->name('role.assign.permission');
        Route::post('/role/revoke-permission', [RolesController::class, 'revokePermission'])->name('role.revoke.permission');


        Route::prefix('role')->controller(RolesController::class)->group(function () {
            Route::get('/', 'index')->name('admin.role');
            Route::get('/fetch-role', 'fetch')->name('role.fetch');
            Route::get('/add', 'add')->name('add.role');
            Route::post('/insert', 'insert')->name('insert.role');
            Route::get('/edit/{id}', 'edit')->name('edit.role');
            Route::post('/update/{id}', 'update')->name('update.role');
            Route::get('/delete/{id}', 'delete')->name('delete.role');
        });

        Route::prefix('permission')->controller(PermissionController::class)->group(function () {
            Route::get('/', 'index')->name('admin.permission');
            Route::get('/fetch-permission', 'fetch')->name('fetch.permission');
            Route::get('/add', 'add')->name('add.permission');
            Route::post('/submit', 'insert')->name('submit.permission');
            Route::get('/delete/{id}', 'delete')->name('permission.delete');
        });

        Route::prefix('cache')->controller(CacheClearController::class)->group(function () {
            Route::get('/', 'index')->name('cache');
            Route::get('/cache-clear', 'clearCache')->name('cache.clear');
            Route::get('/route-cache-clear', 'clearRouteCache')->name('route.cache.clear');
            Route::get('/config-cache-clear', 'clearConfigCache')->name('config.cache.clear');
            Route::get('/view-cache-clear', 'clearViewCache')->name('view.cache.clear');
            Route::get('/compiled-cache-clear', 'clearCompiledCache')->name('compiled.cache.clear');
            Route::get('/optimize-cache-clear', 'optimizeCache')->name('optimize.cache.clear');
        });

        Route::prefix('company')->controller(CompanyController::class)->group(function () {
            Route::get('/', 'index')->name('company');
            Route::get('/fetch-company', 'FetchCompany');
            Route::get('/add', 'AddCompany');
            Route::post('/submit', 'SubmitCompany')->name('submit.company');
            Route::get('/edit/{id}', 'edit');
            Route::post('/update/{id}', 'CompanyUpdate')->name('company.update');
            Route::get('/delete/{id}', 'CompanyDelete')->name('company.delete');
            Route::post('/bulk-delete', 'bulkDelete')->name('bulk.delete.company');
        });

        Route::prefix('task')->controller(TaskController::class)->group(function () {
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

Route::post('/assign-permission', [RolesController::class, 'permissionAssign']);
