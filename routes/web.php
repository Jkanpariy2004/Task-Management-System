<?php

use App\Http\Controllers\Dashboard\AdminController;
use App\Http\Controllers\UserDashboard\CommentController;
use App\Http\Controllers\Dashboard\CompanyController;
use App\Http\Controllers\Dashboard\IndexController;
use App\Http\Controllers\Dashboard\Login\LoginController;
use App\Http\Controllers\Dashboard\PermissionController;
use App\Http\Controllers\Dashboard\RolesController;
use App\Http\Controllers\Dashboard\TaskController;
use App\Http\Controllers\UserDashboard\Login\UserLoginController;
use App\Http\Controllers\Dashboard\UsersController;
use App\Http\Controllers\Dashboard\CacheClearController;
use App\Http\Controllers\UserDashboard\HomeController;
use Illuminate\Support\Facades\Route;


// User Panel Routes
Route::prefix('user')->group(function () {
    Route::controller(UserLoginController::class)->group(function () {
        Route::get('/', 'index')->name('user.login');
        Route::post('/login', 'Userlogin')->name('user.login.check');
        Route::get('/logout', 'UserLogout')->name('user.logout');
    });

    Route::middleware('auth.user')->group(function () {
        Route::controller(HomeController::class)->group(function () {
            Route::get('/dashboard', 'index')->name('user.dashboard');
            Route::get('/Fetch-User-Task', 'FetchUserTask')->name('user.fetch.task');
        });

        Route::post('/comments-store', [CommentController::class, 'store'])->name('comments.store');
    });
});

// Admin Panel Routes
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
    });

    Route::get('users/password-creation-form', [UsersController::class, 'showPasswordCreationForm'])->name('password.creation.form');
    Route::post('users/password-creation', [UsersController::class, 'store']);


    Route::middleware('auth')->group(function () {
        Route::get('/dashboard', [IndexController::class, 'index'])->name('admin.dashboard');

        Route::prefix('users')->controller(UsersController::class)->group(function () {
            Route::get('/list', 'index')->name('list.users');
            Route::get('/add', 'AddUsers')->name('add');
            Route::post('/submit', 'SubmitUser');
            Route::get('/fetch-users', 'FetchUsers');
            Route::get('/delete/{id}', 'UsersDelete')->name('users.delete');
            Route::get('/edit/{id}', 'edit');
            Route::post('/update/{id}', 'UserUpdate')->name('users.update');
            Route::post('/send-invitation', 'sendInvitation');
            Route::post('/bulk-delete', 'bulkDelete')->name('bulk.delete.user');
        });

        Route::prefix('company')->controller(CompanyController::class)->group(function () {
            Route::get('/list', 'index')->name('list.company');
            Route::get('/fetch-company', 'FetchCompany');
            Route::get('/add', 'AddCompany')->name('add.company');
            Route::post('/submit', 'SubmitCompany')->name('submit.company');
            Route::get('/edit/{id}', 'edit')->name('edit.company');
            Route::post('/update/{id}', 'CompanyUpdate')->name('company.update');
            Route::get('/delete/{id}', 'CompanyDelete')->name('company.delete');
            Route::post('/bulk-delete', 'bulkDelete')->name('bulk.delete.company');
            Route::get('/admin/company/export-pdf', 'exportPdf')->name('company.export.pdf');
            Route::post('/import-csv', 'importCSV')->name('import.csv');
        });

        Route::prefix('role')->controller(RolesController::class)->group(function () {
            Route::get('/list', 'index')->name('admin.role');
            Route::get('/fetch-role', 'fetch')->name('role.fetch');
            Route::get('/add', 'add')->name('add.role');
            Route::post('/insert', 'insert')->name('insert.role');
            Route::get('/edit/{id}', 'edit')->name('edit.role');
            Route::post('/update/{id}', 'update')->name('update.role');
            Route::get('/delete/{id}', 'delete')->name('delete.role');
        });

        Route::prefix('permission')->controller(PermissionController::class)->group(function () {
            Route::get('/list', 'index')->name('admin.permission');
            Route::get('/fetch-permission', 'fetch')->name('fetch.permission');
            Route::get('/add', 'add')->name('add.permission');
            Route::post('/submit', 'insert')->name('submit.permission');
            Route::get('/delete/{id}', 'delete')->name('permission.delete');
        });

        Route::prefix('cache')->controller(CacheClearController::class)->group(function () {
            Route::get('/list', 'index')->name('cache');
            Route::get('/cache-clear', 'clearCache')->name('cache.clear');
            Route::get('/route-cache-clear', 'clearRouteCache')->name('route.cache.clear');
            Route::get('/config-cache-clear', 'clearConfigCache')->name('config.cache.clear');
            Route::get('/view-cache-clear', 'clearViewCache')->name('view.cache.clear');
            Route::get('/compiled-cache-clear', 'clearCompiledCache')->name('compiled.cache.clear');
            Route::get('/optimize-cache-clear', 'optimizeCache')->name('optimize.cache.clear');
        });

        Route::prefix('task')->controller(TaskController::class)->group(function () {
            Route::get('/list', 'index')->name('task');
            Route::get('/fetch-task', 'FetchTask')->name('fetch.task');
            Route::get('/add', 'AddTask')->name('add.task');
            Route::post('/submit', 'SubmitTask')->name('submit.task');
            Route::get('/delete/{id}', 'TaskDelete')->name('task.delete');
            Route::post('/bulk-delete', 'bulkDelete')->name('bulk.delete.task');
            Route::get('/edit/{id}', 'edit')->middleware('manage.permission');
            Route::post('/update/{id}', 'TaskUpdate')->name('task.update');
            Route::post('/store-comments', 'store_comment')->name('store.comments');
        });
    });
});

// Global Middleware for Assigning Permissions
Route::post('/assign-permission', [RolesController::class, 'permissionAssign']);


require __DIR__ . '/auth.php';
