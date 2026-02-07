<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Stok;
use App\Repositories\StokRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

/**
 * StokService
 *
 * Stoklar için servis katmanı
 */
class StokService extends BaseService
{
    /**
     * Repository instance
     */
    protected StokRepository $stokRepository;

    /**
     * Constructor
     */
    public function __construct(StokRepository $repository)
    {
        parent::__construct($repository);
        $this->stokRepository = $repository;
    }

    /**
     * Yeni stok oluştur
     *
     * @param array<string, mixed> $data
     */
    public function createStok(array $data): Stok
    {
        return DB::transaction(function () use ($data) {
            return $this->stokRepository->create($data);
        });
    }

    /**
     * Stok güncelle
     *
     * @param array<string, mixed> $data
     */
    public function updateStok(int $id, array $data): bool
    {
        return DB::transaction(function () use ($id, $data) {
            return $this->stokRepository->update($id, $data);
        });
    }

    /**
     * Filtreli arama
     *
     * @param array<string, mixed> $filters
     */
    public function search(array $filters, int $perPage = 15): LengthAwarePaginator
    {
        return $this->stokRepository->getFiltered($filters, $perPage);
    }

    /**
     * Grupları getir
     */
    public function getGruplar(string $column): array
    {
        return $this->stokRepository->getGruplar($column);
    }
}
