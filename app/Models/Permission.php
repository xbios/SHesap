<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Permission Model
 *
 * Yetki tanımları ve rol ilişkileri
 * Migration oluşturulmaz, mevcut tablo kullanılır.
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string|null $description
 * @property string|null $group
 */
class Permission extends Model
{
    /**
     * Veritabanı connection adı
     */
    protected $connection = 'mysql';

    /**
     * Tablo adı
     */
    protected $table = 'permissions';

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
        'group',
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
     * Bu yetkiye sahip roller
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'permission_role', 'permission_id', 'role_id');
    }

    /**
     * Yetki slug'ına göre yetki bulur
     */
    public static function findBySlug(string $slug): ?self
    {
        return static::where('slug', $slug)->first();
    }

    /**
     * Gruba göre yetkileri listeler
     */
    public static function getByGroup(string $group): \Illuminate\Database\Eloquent\Collection
    {
        return static::where('group', $group)->get();
    }
}
