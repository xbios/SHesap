<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Custom Blade Directives for Roles
        \Illuminate\Support\Facades\Blade::if('admin', function () {
            return auth()->check() && auth()->user()->hasRole([\App\Models\Role::SUPER_ADMIN, \App\Models\Role::ADMIN]);
        });

        \Illuminate\Support\Facades\Blade::if('superadmin', function () {
            return auth()->check() && auth()->user()->hasRole(\App\Models\Role::SUPER_ADMIN);
        });

        \Illuminate\Support\Facades\Blade::if('permission', function ($permission) {
            return auth()->check() && auth()->user()->hasPermission($permission);
        });
    }
}
