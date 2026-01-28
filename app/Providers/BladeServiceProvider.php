<?php

declare(strict_types=1);

namespace App\Providers;

use App\Models\Role;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

/**
 * BladeServiceProvider
 *
 * Özel Blade direktifleri için provider.
 * @role, @permission direktiflerini tanımlar.
 */
class BladeServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->registerRoleDirectives();
        $this->registerPermissionDirectives();
    }

    /**
     * @role ve @endrole direktiflerini kaydet
     *
     * Kullanım:
     * @role('admin')
     *     Admin içeriği
     * @endrole
     *
     * @role('admin', 'super-admin')
     *     Admin veya SuperAdmin içeriği
     * @endrole
     */
    protected function registerRoleDirectives(): void
    {
        Blade::directive('role', function ($expression) {
            return "<?php if(auth()->check() && auth()->user()->hasRole({$expression})): ?>";
        });

        Blade::directive('endrole', function () {
            return '<?php endif; ?>';
        });

        // @superadmin direktifi
        Blade::directive('superadmin', function () {
            $role = Role::SUPER_ADMIN;
            return "<?php if(auth()->check() && auth()->user()->hasRole('{$role}')): ?>";
        });

        Blade::directive('endsuperadmin', function () {
            return '<?php endif; ?>';
        });

        // @admin direktifi (SuperAdmin dahil)
        Blade::directive('admin', function () {
            return "<?php if(auth()->check() && auth()->user()->isAdmin()): ?>";
        });

        Blade::directive('endadmin', function () {
            return '<?php endif; ?>';
        });
    }

    /**
     * @permission ve @endpermission direktiflerini kaydet
     *
     * Kullanım:
     * @permission('users.create')
     *     Kullanıcı oluşturma formu
     * @endpermission
     */
    protected function registerPermissionDirectives(): void
    {
        Blade::directive('permission', function ($expression) {
            return "<?php if(auth()->check() && auth()->user()->hasPermission({$expression})): ?>";
        });

        Blade::directive('endpermission', function () {
            return '<?php endif; ?>';
        });

        // @anypermission direktifi
        Blade::directive('anypermission', function ($expression) {
            return "<?php if(auth()->check() && auth()->user()->hasAnyPermission({$expression})): ?>";
        });

        Blade::directive('endanypermission', function () {
            return '<?php endif; ?>';
        });
    }
}
