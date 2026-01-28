<?php

declare(strict_types=1);

namespace App\Traits;

use App\Services\ActivityLogger;
use Illuminate\Support\Facades\App;

/**
 * Loggable Trait
 *
 * Model olaylarını (create, update, delete) otomatik loglar.
 * Model'e use Loggable; ile eklenir.
 */
trait Loggable
{
    /**
     * Loglama için model boot edildiğinde çalışır
     */
    public static function bootLoggable(): void
    {
        // Model oluşturulduğunda
        static::created(function ($model) {
            App::make(ActivityLogger::class)->logCreate($model);
        });

        // Model güncellendiğinde
        static::updated(function ($model) {
            App::make(ActivityLogger::class)->logUpdate($model);
        });

        // Model silindiğinde
        static::deleted(function ($model) {
            App::make(ActivityLogger::class)->logDelete($model);
        });
    }

    /**
     * Loglama sırasında kullanılacak öznitelikler
     * Model'de bu metodu override ederek özelleştirebilirsiniz
     *
     * @return array<string, mixed>
     */
    public function getLoggableAttributes(): array
    {
        return $this->getAttributes();
    }

    /**
     * Log'dan hariç tutulacak alanlar
     * Model'de bu metodu override ederek özelleştirebilirsiniz
     *
     * @return array<string>
     */
    public function getLogExceptAttributes(): array
    {
        return ['password', 'remember_token'];
    }

    /**
     * Loglama için güvenli veriyi döner (hassas alanlar çıkarılmış)
     *
     * @return array<string, mixed>
     */
    public function getSafeLogAttributes(): array
    {
        $attributes = $this->getLoggableAttributes();
        $except = $this->getLogExceptAttributes();

        return array_diff_key($attributes, array_flip($except));
    }
}
