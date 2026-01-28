<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * ActivityLog Model
 *
 * Sistem aktivite logları için model
 * Migration oluşturulmaz, mevcut tablo kullanılır.
 *
 * @property int $id
 * @property int|null $user_id
 * @property string $action
 * @property string|null $model_type
 * @property int|null $model_id
 * @property array|null $old_values
 * @property array|null $new_values
 * @property string|null $ip_address
 * @property string|null $user_agent
 * @property \Illuminate\Support\Carbon $created_at
 */
class ActivityLog extends Model
{
    /**
     * Log veritabanı connection'ı kullan
     */
    protected $connection = 'mysql_logs';

    /**
     * Tablo adı
     */
    protected $table = 'activity_logs';

    /**
     * Primary key kolonu
     */
    protected $primaryKey = 'id';

    /**
     * Sadece created_at kullan
     */
    public $timestamps = true;
    public const UPDATED_AT = null;

    /**
     * Mass assignment için izin verilen kolonlar
     *
     * @var list<string>
     */
    protected $fillable = [
        'user_id',
        'action',
        'model_type',
        'model_id',
        'old_values',
        'new_values',
        'ip_address',
        'user_agent',
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
            'old_values' => 'array',
            'new_values' => 'array',
            'created_at' => 'datetime',
        ];
    }

    /**
     * Aksiyon tipleri
     */
    public const ACTION_CREATE = 'create';
    public const ACTION_UPDATE = 'update';
    public const ACTION_DELETE = 'delete';
    public const ACTION_LOGIN = 'login';
    public const ACTION_LOGOUT = 'logout';
    public const ACTION_VIEW = 'view';

    /**
     * Log sahibi kullanıcı
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * İlişkili model
     */
    public function subject(): ?\Illuminate\Database\Eloquent\Model
    {
        if ($this->model_type && $this->model_id) {
            return $this->model_type::find($this->model_id);
        }

        return null;
    }

    /**
     * Kullanıcıya göre logları filtrele
     */
    public function scopeByUser(\Illuminate\Database\Eloquent\Builder $query, int $userId): \Illuminate\Database\Eloquent\Builder
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Aksiyona göre logları filtrele
     */
    public function scopeByAction(\Illuminate\Database\Eloquent\Builder $query, string $action): \Illuminate\Database\Eloquent\Builder
    {
        return $query->where('action', $action);
    }

    /**
     * Model tipine göre logları filtrele
     */
    public function scopeByModel(\Illuminate\Database\Eloquent\Builder $query, string $modelType): \Illuminate\Database\Eloquent\Builder
    {
        return $query->where('model_type', $modelType);
    }
}
