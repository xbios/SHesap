<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Cari;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * CariRepository
 *
 * Cari hesaplar için repository
 */
class CariRepository extends BaseRepository
{
    /**
     * Repository'nin çalışacağı model sınıfı
     */
    protected function model(): string
    {
        return Cari::class;
    }

    /**
     * Filtreleme ile sayfalı liste
     *
     * @param array<string, mixed> $filters
     */
    public function getFiltered(array $filters, int $perPage = 15): LengthAwarePaginator
    {
        $query = $this->query();

        if (!empty($filters['firma_id'])) {
            $query->where('SFIRMAID', $filters['firma_id']);
        }

        if (!empty($filters['search'])) {
            $query->search($filters['search']);
        }

        if (!empty($filters['sehir'])) {
            $query->where('CRSEHIR', $filters['sehir']);
        }

        $sortBy = $filters['sort_by'] ?? 'CRISIM';
        $sortOrder = $filters['sort_order'] ?? 'asc';
        $query->orderBy($sortBy, $sortOrder);

        return $query->paginate($perPage);
    }

    /**
     * Cari kodu ile bul
     */
    public function findByKod(string $kod): ?Cari
    {
        return $this->query()->where('CRKOD', $kod)->first();
    }

    /**
     * Şehirleri listele (distinct)
     */
    public function getSehirler(): Collection
    {
        return $this->query()
            ->select('CRSEHIR')
            ->whereNotNull('CRSEHIR')
            ->where('CRSEHIR', '!=', '')
            ->distinct()
            ->orderBy('CRSEHIR')
            ->get();
    }
}
