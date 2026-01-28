<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Blade tabanlı web route'ları.
|
*/

Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| AUTH ROUTES (Login, Register, Logout)
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('/login', function () {
        return view('auth.login');
    })->name('login');

    Route::post('/login', [\App\Http\Controllers\Auth\LoginController::class, 'login']);
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [\App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');
});


/*
|--------------------------------------------------------------------------
| DASHBOARD ROUTES (Auth gerektirir)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard.index');
    })->name('dashboard');

    // Cari Hesaplar CRUD
    Route::resource('cari', \App\Http\Controllers\CariController::class);

    // Örnek CRUD Resource Route
    // Route::resource('examples', \App\Http\Controllers\Examples\ExampleController::class);
});


/*
|--------------------------------------------------------------------------
| ADMIN ROUTES (Rol gerektirir)
|--------------------------------------------------------------------------
*/
// Route::middleware(['auth', 'role:super-admin,admin'])->prefix('admin')->name('admin.')->group(function () {
//     Route::resource('users', \App\Http\Controllers\Admin\UserController::class);
//     Route::resource('roles', \App\Http\Controllers\Admin\RoleController::class);
// });


/*
|--------------------------------------------------------------------------
| PLACEHOLDER ROUTES (Sidebar için)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/users', fn() => view('dashboard.index'))->name('users.index');
    Route::get('/roles', fn() => view('dashboard.index'))->name('roles.index');
    Route::get('/settings', fn() => view('dashboard.index'))->name('settings.index');
    Route::get('/logs', fn() => view('dashboard.index'))->name('logs.index');
});
