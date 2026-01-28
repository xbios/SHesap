<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * PermissionMiddleware
 *
 * Route seviyesinde yetki kontrolü sağlar.
 *
 * Kullanım:
 * Route::middleware('permission:users.create')->group(...);
 * Route::middleware('permission:users.view,users.edit')->group(...);
 */
class PermissionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     * @param string $permissions Virgülle ayrılmış yetki slug'ları
     */
    public function handle(Request $request, Closure $next, string $permissions): Response
    {
        $user = $request->user();

        if (!$user) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Oturum açmanız gerekiyor.',
                ], 401);
            }

            return redirect()->route('login');
        }

        $permissionsArray = array_map('trim', explode(',', $permissions));

        // En az bir yetkiye sahip olmalı
        if (!$user->hasAnyPermission($permissionsArray)) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Bu işlem için yetkiniz bulunmuyor.',
                ], 403);
            }

            abort(403, 'Bu işlem için yetkiniz bulunmuyor.');
        }

        return $next($request);
    }
}
