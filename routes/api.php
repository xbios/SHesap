<?php

use App\Http\Controllers\Api\AuthController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Sanctum ile korunan API route'ları.
| Tüm route'lar /api prefix'i ile erişilir.
|
*/

/*
|--------------------------------------------------------------------------
| PUBLIC ROUTES (Authentication gerektirmeyen)
|--------------------------------------------------------------------------
*/
Route::prefix('auth')->group(function () {
    Route::post('/login', [AuthController::class, 'login'])->name('api.auth.login');
});


/*
|--------------------------------------------------------------------------
| PROTECTED ROUTES (Sanctum authentication gerektirir)
|--------------------------------------------------------------------------
*/
Route::middleware('auth:sanctum')->group(function () {

    // Auth routes
    Route::prefix('auth')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout'])->name('api.auth.logout');
        Route::post('/logout-all', [AuthController::class, 'logoutAll'])->name('api.auth.logout-all');
        Route::post('/refresh', [AuthController::class, 'refresh'])->name('api.auth.refresh');
        Route::get('/me', [AuthController::class, 'me'])->name('api.auth.me');
    });

    /*
    |--------------------------------------------------------------------------
    | ÖRNEK RESOURCE ROUTES
    |--------------------------------------------------------------------------
    | Aşağıdaki şekilde yeni resource route'ları ekleyebilirsiniz:
    |
    | Route::apiResource('examples', ExampleApiController::class);
    |
    | Bu otomatik olarak şu route'ları oluşturur:
    | - GET    /api/examples          -> index
    | - POST   /api/examples          -> store
    | - GET    /api/examples/{id}     -> show
    | - PUT    /api/examples/{id}     -> update
    | - DELETE /api/examples/{id}     -> destroy
    */

    // Rol Bazlı Route'lar Örneği
    // Route::middleware('role:admin')->group(function () {
    //     Route::apiResource('users', UserApiController::class);
    // });

    // Yetki Bazlı Route'lar Örneği
    // Route::middleware('permission:settings.view')->group(function () {
    //     Route::get('/settings', [SettingsController::class, 'index']);
    // });
});
