<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Role Model
 *
 * Sistem rolleri: SuperAdmin, Admin, Kullanıcı
 * Migration oluşturulmaz, mevcut tablo kullanılır.
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string|null $description
 */
class Role extends Model
{
    /**
     * Veritabanı connection adı
     */
    protected $connection = 'mysql';

    /**
     * Tablo adı
     */
    protected $table = 'roles';

    /**
     * Primary key kolonu
     */
    protected $primaryKey = 'id';

    /**
     * Timestamps kullanımı
     */
    public $timestamps = true;

    /**
     * Mass assignment için izin verilen kolonlar
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'slug',
        'description',
    ];

    /**
     * Kolon tip dönüşümleri
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    /**
     * Rol sabitleri
     */
    public const SUPER_ADMIN = 'super-admin';
    public const ADMIN = 'admin';
    public const USER = 'user';

    /**
     * Role ait kullanıcılar
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'role_user', 'role_id', 'user_id');
    }

    /**
     * Role ait yetkiler
     */
    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(Permission::class, 'permission_role', 'role_id', 'permission_id');
    }

    /**
     * Rolün belirli bir yetkiye sahip olup olmadığını kontrol eder
     */
    public function hasPermission(string $permission): bool
    {
        return $this->permissions()->where('slug', $permission)->exists();
    }

    /**
     * Rol slug'ına göre rol bulur
     */
    public static function findBySlug(string $slug): ?self
    {
        return static::where('slug', $slug)->first();
    }
}
