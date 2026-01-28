<?php

declare(strict_types=1);

namespace App\Models;

use App\Traits\HasRoles;
use App\Traits\Loggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * User Model
 *
 * Bu model harici auth tablolarıyla çalışır.
 * Migration oluşturulmaz, mevcut tablo kullanılır.
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 */
class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasRoles;
    use Loggable;
    use Notifiable;

    /**
     * Veritabanı connection adı
     * Farklı bir connection kullanmak için değiştirin
     */
    protected $connection = 'mysql';

    /**
     * Tablo adı
     * Mevcut tablonuzun adını buraya yazın
     */
    protected $table = 'users';

    /**
     * Primary key kolonu
     */
    protected $primaryKey = 'id';

    /**
     * Primary key tipi
     */
    protected $keyType = 'int';

    /**
     * Auto-increment durumu
     */
    public $incrementing = true;

    /**
     * Timestamps kullanım durumu
     */
    public $timestamps = true;

    /**
     * Mass assignment için izin verilen kolonlar
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * Gizlenecek kolonlar (JSON/array dönüşümünde)
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Kolon tip dönüşümleri
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    /**
     * Kullanıcının tam adını döner
     */
    public function getFullNameAttribute(): string
    {
        return $this->name;
    }
}
