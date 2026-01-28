<?php

declare(strict_types=1);

namespace App\Services;

use App\Repositories\Contracts\BaseRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

/**
 * BaseService
 *
 * Tüm service'ler için temel sınıf.
 * İş kuralları bu katmanda uygulanır.
 * Repository ile çalışır, DB işlemlerini repository'e delege eder.
 */
abstract class BaseService
{
    /**
     * Service'in kullanacağı repository
     */
    protected BaseRepositoryInterface $repository;

    /**
     * Constructor - Repository injection
     */
    public function __construct(BaseRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Tüm kayıtları listele
     *
     * @param array<string> $columns
     */
    public function all(array $columns = ['*']): Collection
    {
        return $this->repository->all($columns);
    }

    /**
     * ID ile kayıt getir
     */
    public function find(int|string $id, array $columns = ['*']): ?Model
    {
        return $this->repository->find($id, $columns);
    }

    /**
     * ID ile kayıt getir, bulamazsa hata fırlat
     */
    public function findOrFail(int|string $id, array $columns = ['*']): Model
    {
        return $this->repository->findOrFail($id, $columns);
    }

    /**
     * Yeni kayıt oluştur
     *
     * @param array<string, mixed> $data
     */
    public function create(array $data): Model
    {
        return DB::transaction(function () use ($data) {
            return $this->repository->create($data);
        });
    }

    /**
     * Kayıt güncelle
     *
     * @param array<string, mixed> $data
     */
    public function update(int|string $id, array $data): bool
    {
        return DB::transaction(function () use ($id, $data) {
            return $this->repository->update($id, $data);
        });
    }

    /**
     * Kayıt sil
     */
    public function delete(int|string $id): bool
    {
        return DB::transaction(function () use ($id) {
            return $this->repository->delete($id);
        });
    }

    /**
     * Sayfalı liste
     */
    public function paginate(int $perPage = 15, array $columns = ['*']): LengthAwarePaginator
    {
        return $this->repository->paginate($perPage, $columns);
    }

    /**
     * Toplam kayıt sayısı
     */
    public function count(): int
    {
        return $this->repository->count();
    }
}
