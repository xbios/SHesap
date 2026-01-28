<?php

declare(strict_types=1);

namespace App\Services\Examples;

use App\Models\Examples\ExampleModel;
use App\Repositories\Examples\ExampleRepository;
use App\Services\BaseService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

/**
 * ExampleService
 *
 * Service şablonu - yeni service oluştururken bu dosyayı referans alın.
 *
 * KULLANIM:
 * 1. Bu dosyayı kopyalayın
 * 2. Namespace ve class adını değiştirin
 * 3. Constructor'da doğru repository'yi inject edin
 * 4. İş kurallarını burada tanımlayın
 */
class ExampleService extends BaseService
{
    /**
     * Repository instance
     */
    protected ExampleRepository $exampleRepository;

    /**
     * Constructor - Repository injection
     */
    public function __construct(ExampleRepository $repository)
    {
        parent::__construct($repository);
        $this->exampleRepository = $repository;
    }

    /*
    |--------------------------------------------------------------------------
    | İŞ KURALLARI
    |--------------------------------------------------------------------------
    | Validasyon ve iş mantığı burada uygulanır.
    | DB işlemleri repository'e delege edilir.
    */

    /**
     * Yeni kayıt oluştur (iş kuralları ile)
     *
     * @param array<string, mixed> $data
     */
    public function createWithRules(array $data): ExampleModel
    {
        return DB::transaction(function () use ($data) {
            // İş kuralları uygula
            $data['is_active'] = $data['is_active'] ?? true;

            // Kayıt oluştur
            return $this->exampleRepository->create($data);
        });
    }

    /**
     * Kayıt güncelle (iş kuralları ile)
     *
     * @param array<string, mixed> $data
     */
    public function updateWithRules(int $id, array $data): bool
    {
        return DB::transaction(function () use ($id, $data) {
            $model = $this->exampleRepository->findOrFail($id);

            // İş kurallarını kontrol et
            if ($model->is_active && isset($data['is_active']) && !$data['is_active']) {
                // Deaktive etmeden önce kontrol
                $this->validateDeactivation($model);
            }

            return $this->exampleRepository->update($id, $data);
        });
    }

    /**
     * Aktif kayıtları listele
     */
    public function getActive(): Collection
    {
        return $this->exampleRepository->getActive();
    }

    /**
     * Kullanıcının kayıtlarını getir
     */
    public function getByUser(int $userId): Collection
    {
        return $this->exampleRepository->getByUser($userId);
    }

    /**
     * Filtreli arama
     *
     * @param array<string, mixed> $filters
     */
    public function search(array $filters, int $perPage = 15): LengthAwarePaginator
    {
        return $this->exampleRepository->getFiltered($filters, $perPage);
    }

    /**
     * İstatistikleri getir
     *
     * @return array<string, int>
     */
    public function getStatistics(): array
    {
        return $this->exampleRepository->getStats();
    }

    /**
     * Toplu aktif et
     *
     * @param array<int> $ids
     */
    public function bulkActivate(array $ids): int
    {
        return $this->exampleRepository->bulkUpdate($ids, ['is_active' => true]);
    }

    /**
     * Toplu deaktif et
     *
     * @param array<int> $ids
     */
    public function bulkDeactivate(array $ids): int
    {
        return $this->exampleRepository->bulkUpdate($ids, ['is_active' => false]);
    }

    /*
    |--------------------------------------------------------------------------
    | PRİVATE YARDIMCI METODLAR
    |--------------------------------------------------------------------------
    */

    /**
     * Deaktivasyon validasyonu
     *
     * @throws \Exception
     */
    private function validateDeactivation(ExampleModel $model): void
    {
        // Örnek: İlişkili kayıtlar varsa deaktive edilemez
        // if ($model->items()->exists()) {
        //     throw new \Exception('İlişkili öğeler varken deaktive edilemez.');
        // }
    }
}
