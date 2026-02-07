<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Stok;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * StokRepository
 *
 * Stoklar için repository
 */
class StokRepository extends BaseRepository
{
    /**
     * Repository'nin çalışacağı model sınıfı
     */
    protected function model(): string
    {
        return Stok::class;
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

        if (!empty($filters['grup1'])) {
            $query->where('STOKGRP1', $filters['grup1']);
        }

        if (!empty($filters['grup2'])) {
            $query->where('STOKGRP2', $filters['grup2']);
        }

        $sortBy = $filters['sort_by'] ?? 'STOKADI';
        $sortOrder = $filters['sort_order'] ?? 'asc';
        $query->orderBy($sortBy, $sortOrder);

        return $query->paginate($perPage);
    }

    /**
     * Stok kodu ile bul
     */
    public function findByKod(string $kod): ?Stok
    {
        return $this->query()->where('STOKKOD', $kod)->first();
    }

    /**
     * Stok gruplarını listele
     */
    public function getGruplar(string $column): array
    {
        return $this->query()
            ->select($column)
            ->whereNotNull($column)
            ->where($column, '!=', '')
            ->distinct()
            ->orderBy($column)
            ->pluck($column)
            ->toArray();
    }
}
