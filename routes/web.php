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

    // Stoklar CRUD
    Route::resource('stok', \App\Http\Controllers\StokController::class);

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
Route::middleware(['auth'])->group(function () {
    // Kullanıcılar
    Route::resource('users', \App\Http\Controllers\Admin\UserController::class);
    
    // Roller
    Route::resource('roles', \App\Http\Controllers\Admin\RoleController::class);
    
    // Ayarlar
    Route::get('/settings', [\App\Http\Controllers\Admin\SettingController::class, 'index'])->name('settings.index');
    Route::post('/settings', [\App\Http\Controllers\Admin\SettingController::class, 'update'])->name('settings.update');
    
    // Loglar
    Route::get('/logs', [\App\Http\Controllers\Admin\ActivityLogController::class, 'index'])->name('logs.index');
});
