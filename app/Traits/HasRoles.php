<?php

declare(strict_types=1);

namespace App\Traits;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * HasRoles Trait
 *
 * Kullanıcı modellerine rol ve yetki kontrolü ekler.
 * User modeline use HasRoles; ile eklenir.
 */
trait HasRoles
{
    /**
     * Kullanıcının rolleri
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'role_user', 'user_id', 'role_id');
    }

    /**
     * Kullanıcının direkt yetkileri (opsiyonel)
     */
    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(Permission::class, 'permission_user', 'user_id', 'permission_id');
    }

    /**
     * Kullanıcının belirli bir role sahip olup olmadığını kontrol eder
     *
     * @param string|array $roles Rol slug'ı veya slug dizisi
     */
    public function hasRole(string|array $roles): bool
    {
        $roles = is_array($roles) ? $roles : [$roles];

        return $this->roles()->whereIn('slug', $roles)->exists();
    }

    /**
     * Kullanıcının belirli bir yetkiye sahip olup olmadığını kontrol eder
     * Önce direkt yetkiler, sonra rol yetkileri kontrol edilir
     *
     * @param string $permission Yetki slug'ı
     */
    public function hasPermission(string $permission): bool
    {
        // SuperAdmin her şeye yetkili
        if ($this->hasRole(Role::SUPER_ADMIN)) {
            return true;
        }

        // Direkt kullanıcı yetkisi kontrolü
        if ($this->permissions()->where('slug', $permission)->exists()) {
            return true;
        }

        // Rol yetkileri kontrolü
        foreach ($this->roles as $role) {
            if ($role->hasPermission($permission)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Kullanıcının verilen yetkilerden herhangi birine sahip olup olmadığını kontrol eder
     *
     * @param array $permissions Yetki slug'ları
     */
    public function hasAnyPermission(array $permissions): bool
    {
        foreach ($permissions as $permission) {
            if ($this->hasPermission($permission)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Kullanıcının verilen yetkilerin tümüne sahip olup olmadığını kontrol eder
     *
     * @param array $permissions Yetki slug'ları
     */
    public function hasAllPermissions(array $permissions): bool
    {
        foreach ($permissions as $permission) {
            if (!$this->hasPermission($permission)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Kullanıcıya rol atar
     *
     * @param string|int|Role $role Rol slug, id veya model
     */
    public function assignRole(string|int|Role $role): void
    {
        if (is_string($role)) {
            $role = Role::findBySlug($role);
        } elseif (is_int($role)) {
            $role = Role::findOrFail($role);
        }

        if ($role && !$this->hasRole($role->slug)) {
            $this->roles()->attach($role->id);
        }
    }

    /**
     * Kullanıcıdan rol kaldırır
     *
     * @param string|int|Role $role Rol slug, id veya model
     */
    public function removeRole(string|int|Role $role): void
    {
        if (is_string($role)) {
            $role = Role::findBySlug($role);
        } elseif (is_int($role)) {
            $role = Role::findOrFail($role);
        }

        if ($role) {
            $this->roles()->detach($role->id);
        }
    }

    /**
     * Kullanıcının tüm rollerini senkronize eder
     *
     * @param array $roles Rol id'leri
     */
    public function syncRoles(array $roles): void
    {
        $this->roles()->sync($roles);
    }

    /**
     * SuperAdmin kontrolü
     */
    public function isSuperAdmin(): bool
    {
        return $this->hasRole(Role::SUPER_ADMIN);
    }

    /**
     * Admin kontrolü (SuperAdmin dahil)
     */
    public function isAdmin(): bool
    {
        return $this->hasRole([Role::SUPER_ADMIN, Role::ADMIN]);
    }
}
