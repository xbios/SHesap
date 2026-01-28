<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Models\Role;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * RoleMiddleware
 *
 * Route seviyesinde rol kontrolü sağlar.
 *
 * Kullanım:
 * Route::middleware('role:admin')->group(...);
 * Route::middleware('role:super-admin,admin')->group(...);
 */
class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     * @param string $roles Virgülle ayrılmış rol slug'ları
     */
    public function handle(Request $request, Closure $next, string $roles): Response
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

        $rolesArray = array_map('trim', explode(',', $roles));

        if (!$user->hasRole($rolesArray)) {
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
