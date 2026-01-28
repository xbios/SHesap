<?php

declare(strict_types=1);

namespace App\Repositories\Contracts;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * BaseRepositoryInterface
 *
 * Tüm repository'ler için temel arayüz.
 * CRUD operasyonları ve yaygın sorgular için standart metodlar tanımlar.
 */
interface BaseRepositoryInterface
{
    /**
     * Tüm kayıtları getir
     *
     * @param array<string> $columns Döndürülecek kolonlar
     */
    public function all(array $columns = ['*']): Collection;

    /**
     * ID ile tek kayıt getir
     */
    public function find(int|string $id, array $columns = ['*']): ?Model;

    /**
     * ID ile kayıt getir, bulamazsa hata fırlat
     */
    public function findOrFail(int|string $id, array $columns = ['*']): Model;

    /**
     * Belirli bir kolona göre kayıt bul
     */
    public function findBy(string $field, mixed $value, array $columns = ['*']): ?Model;

    /**
     * Belirli bir kolona göre tüm kayıtları bul
     */
    public function findAllBy(string $field, mixed $value, array $columns = ['*']): Collection;

    /**
     * Yeni kayıt oluştur
     *
     * @param array<string, mixed> $data
     */
    public function create(array $data): Model;

    /**
     * Kayıt güncelle
     *
     * @param array<string, mixed> $data
     */
    public function update(int|string $id, array $data): bool;

    /**
     * Kayıt sil
     */
    public function delete(int|string $id): bool;

    /**
     * Sayfalı liste getir
     */
    public function paginate(int $perPage = 15, array $columns = ['*']): LengthAwarePaginator;

    /**
     * Koşullu sorgu
     *
     * @param array<string, mixed> $criteria
     */
    public function findWhere(array $criteria, array $columns = ['*']): Collection;

    /**
     * Toplam kayıt sayısı
     */
    public function count(): int;
}
