<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Cari;
use App\Repositories\CariRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

/**
 * CariService
 *
 * Cari hesaplar için servis katmanı
 */
class CariService extends BaseService
{
    /**
     * Repository instance
     */
    protected CariRepository $cariRepository;

    /**
     * Constructor
     */
    public function __construct(CariRepository $repository)
    {
        parent::__construct($repository);
        $this->cariRepository = $repository;
    }

    /**
     * Yeni cari oluştur
     *
     * @param array<string, mixed> $data
     */
    public function createCari(array $data): Cari
    {
        return DB::transaction(function () use ($data) {
            return $this->cariRepository->create($data);
        });
    }

    /**
     * Cari güncelle
     *
     * @param array<string, mixed> $data
     */
    public function updateCari(int $id, array $data): bool
    {
        return DB::transaction(function () use ($id, $data) {
            return $this->cariRepository->update($id, $data);
        });
    }

    /**
     * Filtreli arama
     *
     * @param array<string, mixed> $filters
     */
    public function search(array $filters, int $perPage = 15): LengthAwarePaginator
    {
        return $this->cariRepository->getFiltered($filters, $perPage);
    }

    /**
     * Cari kodu ile bul
     */
    public function findByKod(string $kod): ?Cari
    {
        return $this->cariRepository->findByKod($kod);
    }

    /**
     * Şehirleri listele
     */
    public function getSehirler(): Collection
    {
        return $this->cariRepository->getSehirler();
    }
}
