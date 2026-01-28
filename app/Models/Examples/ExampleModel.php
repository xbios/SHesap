<?php

declare(strict_types=1);

namespace App\Models\Examples;

use App\Traits\Loggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * ExampleModel
 *
 * Model şablonu - yeni model oluştururken bu dosyayı referans alın.
 *
 * KULLANIM:
 * 1. Bu dosyayı kopyalayın
 * 2. Namespace ve class adını değiştirin
 * 3. $connection, $table, $primaryKey değerlerini ayarlayın
 * 4. $fillable ve $casts değerlerini güncelleyin
 * 5. İlişkileri ekleyin
 *
 * @property int $id Primary key
 * @property string $name Örnek alan
 * @property int $user_id İlişkili kullanıcı
 * @property bool $is_active Aktif mi?
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 */
class ExampleModel extends Model
{
    use Loggable;

    /*
    |--------------------------------------------------------------------------
    | DATABASE AYARLARI
    |--------------------------------------------------------------------------
    */

    /**
     * Veritabanı connection adı
     * config/database.php içindeki connection adı
     */
    protected $connection = 'mysql';

    /**
     * Tablo adı
     * Mevcut tablonuzun adını buraya yazın
     */
    protected $table = 'examples';

    /**
     * Primary key kolonu
     */
    protected $primaryKey = 'id';

    /**
     * Primary key tipi ('int' veya 'string')
     */
    protected $keyType = 'int';

    /**
     * Auto-increment durumu
     */
    public $incrementing = true;

    /**
     * Timestamps kullanımı
     * Tablo created_at/updated_at içermiyorsa false yapın
     */
    public $timestamps = true;

    /**
     * Timestamp kolon adları (farklı isimler kullanıyorsanız)
     */
    // public const CREATED_AT = 'creation_date';
    // public const UPDATED_AT = 'last_update';

    /*
    |--------------------------------------------------------------------------
    | MASS ASSIGNMENT
    |--------------------------------------------------------------------------
    */

    /**
     * Mass assignment için izin verilen kolonlar
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'user_id',
        'is_active',
        'metadata',
    ];

    /**
     * Mass assignment'tan korunan kolonlar (fillable yerine kullanılabilir)
     *
     * @var list<string>
     */
    // protected $guarded = ['id'];

    /*
    |--------------------------------------------------------------------------
    | TİP DÖNÜŞÜMLER (CASTS)
    |--------------------------------------------------------------------------
    */

    /**
     * Kolon tip dönüşümleri
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'metadata' => 'array',       // JSON alanı için
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            // 'date_field' => 'date',
            // 'decimal_field' => 'decimal:2',
            // 'enum_field' => StatusEnum::class, // PHP 8.1+ enum
        ];
    }

    /**
     * Gizlenecek kolonlar (JSON/array dönüşümünde)
     *
     * @var list<string>
     */
    // protected $hidden = ['password'];

    /**
     * JSON dönüşümünde dahil edilecek özellikler
     *
     * @var list<string>
     */
    // protected $appends = ['full_name'];

    /*
    |--------------------------------------------------------------------------
    | İLİŞKİLER (RELATIONSHIPS)
    |--------------------------------------------------------------------------
    */

    /**
     * Sahip kullanıcı (BelongsTo ilişkisi)
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    /**
     * HasMany örneği
     */
    // public function items(): \Illuminate\Database\Eloquent\Relations\HasMany
    // {
    //     return $this->hasMany(Item::class);
    // }

    /**
     * BelongsToMany örneği (pivot tablo)
     */
    // public function tags(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    // {
    //     return $this->belongsToMany(Tag::class, 'example_tag', 'example_id', 'tag_id');
    // }

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    /**
     * Aktif kayıtları filtrele
     */
    public function scopeActive(\Illuminate\Database\Eloquent\Builder $query): \Illuminate\Database\Eloquent\Builder
    {
        return $query->where('is_active', true);
    }

    /**
     * Kullanıcıya göre filtrele
     */
    public function scopeByUser(\Illuminate\Database\Eloquent\Builder $query, int $userId): \Illuminate\Database\Eloquent\Builder
    {
        return $query->where('user_id', $userId);
    }

    /*
    |--------------------------------------------------------------------------
    | ACCESSORS & MUTATORS
    |--------------------------------------------------------------------------
    */

    /**
     * Accessor örneği: Büyük harfli isim
     */
    public function getNameUpperAttribute(): string
    {
        return strtoupper($this->name);
    }

    /**
     * Mutator örneği: İsmi trim et
     */
    public function setNameAttribute(string $value): void
    {
        $this->attributes['name'] = trim($value);
    }

    /*
    |--------------------------------------------------------------------------
    | LOGGABLE AYARLARI
    |--------------------------------------------------------------------------
    */

    /**
     * Log'dan hariç tutulacak alanlar
     *
     * @return array<string>
     */
    public function getLogExceptAttributes(): array
    {
        return ['metadata'];
    }
}
