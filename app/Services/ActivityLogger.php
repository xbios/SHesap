<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\ActivityLog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request;

/**
 * ActivityLogger Service
 *
 * Sistem aktivitelerini hem veritabanına hem dosyaya loglar.
 * Transaction içindeki kritik işlemler için kullanılır.
 */
class ActivityLogger
{
    /**
     * Model oluşturma log'u
     */
    public function logCreate(Model $model): void
    {
        $this->log(
            action: ActivityLog::ACTION_CREATE,
            model: $model,
            newValues: $this->getSafeAttributes($model)
        );
    }

    /**
     * Model güncelleme log'u
     */
    public function logUpdate(Model $model): void
    {
        $original = $model->getOriginal();
        $changes = $model->getChanges();

        // Hassas alanları temizle
        $original = $this->filterSensitive($original, $model);
        $changes = $this->filterSensitive($changes, $model);

        $this->log(
            action: ActivityLog::ACTION_UPDATE,
            model: $model,
            oldValues: $original,
            newValues: $changes
        );
    }

    /**
     * Model silme log'u
     */
    public function logDelete(Model $model): void
    {
        $this->log(
            action: ActivityLog::ACTION_DELETE,
            model: $model,
            oldValues: $this->getSafeAttributes($model)
        );
    }

    /**
     * Kullanıcı giriş log'u
     */
    public function logLogin(?Model $user = null): void
    {
        $this->log(
            action: ActivityLog::ACTION_LOGIN,
            model: $user,
            description: 'Kullanıcı giriş yaptı'
        );
    }

    /**
     * Kullanıcı çıkış log'u
     */
    public function logLogout(?Model $user = null): void
    {
        $this->log(
            action: ActivityLog::ACTION_LOGOUT,
            model: $user,
            description: 'Kullanıcı çıkış yaptı'
        );
    }

    /**
     * Özel log kaydı
     */
    public function logCustom(string $action, ?Model $model = null, ?string $description = null, array $data = []): void
    {
        $this->log(
            action: $action,
            model: $model,
            description: $description,
            newValues: $data
        );
    }

    /**
     * Ana log metodu
     */
    protected function log(
        string $action,
        ?Model $model = null,
        ?array $oldValues = null,
        ?array $newValues = null,
        ?string $description = null
    ): void {
        try {
            $userId = Auth::id();
            $ipAddress = Request::ip();
            $userAgent = Request::userAgent();

            $logData = [
                'user_id' => $userId,
                'action' => $action,
                'model_type' => $model ? get_class($model) : null,
                'model_id' => $model?->getKey(),
                'old_values' => $oldValues,
                'new_values' => $newValues,
                'ip_address' => $ipAddress,
                'user_agent' => $userAgent,
                'description' => $description,
            ];

            // Veritabanına yaz
            $this->writeToDatabase($logData);

            // Dosyaya yaz
            $this->writeToFile($logData);

        } catch (\Throwable $e) {
            // Log hatası ana işlemi engellemez
            Log::error('ActivityLogger hatası: ' . $e->getMessage(), [
                'exception' => $e,
            ]);
        }
    }

    /**
     * Veritabanına log yaz
     */
    protected function writeToDatabase(array $data): void
    {
        // Transaction dışında log yaz ki kritik işlemler rollback olsa bile log kaybolmasın
        DB::connection('mysql_logs')->table('activity_logs')->insert([
            ...$data,
            'old_values' => $data['old_values'] ? json_encode($data['old_values']) : null,
            'new_values' => $data['new_values'] ? json_encode($data['new_values']) : null,
            'created_at' => now(),
        ]);
    }

    /**
     * Dosyaya log yaz
     */
    protected function writeToFile(array $data): void
    {
        $message = sprintf(
            '[%s] %s | User: %s | Model: %s(%s) | IP: %s',
            $data['action'],
            $data['description'] ?? '-',
            $data['user_id'] ?? 'guest',
            $data['model_type'] ?? '-',
            $data['model_id'] ?? '-',
            $data['ip_address'] ?? '-'
        );

        Log::channel('activity')->info($message, $data);
    }

    /**
     * Model'den güvenli öznitelikleri al
     */
    protected function getSafeAttributes(Model $model): array
    {
        if (method_exists($model, 'getSafeLogAttributes')) {
            return $model->getSafeLogAttributes();
        }

        return $model->getAttributes();
    }

    /**
     * Hassas alanları filtrele
     */
    protected function filterSensitive(array $data, Model $model): array
    {
        $sensitive = ['password', 'remember_token'];

        if (method_exists($model, 'getLogExceptAttributes')) {
            $sensitive = $model->getLogExceptAttributes();
        }

        return array_diff_key($data, array_flip($sensitive));
    }
}
