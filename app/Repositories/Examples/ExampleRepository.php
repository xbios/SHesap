<?php

declare(strict_types=1);

namespace App\Repositories\Examples;

use App\Models\Examples\ExampleModel;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * ExampleRepository
 *
 * Repository şablonu - yeni repository oluştururken bu dosyayı referans alın.
 *
 * KULLANIM:
 * 1. Bu dosyayı kopyalayın
 * 2. Namespace ve class adını değiştirin
 * 3. model() metodunda doğru model sınıfını döndürün
 * 4. Özel sorgu metodlarını ekleyin
 */
class ExampleRepository extends BaseRepository
{
    /**
     * Repository'nin çalışacağı model sınıfı
     */
    protected function model(): string
    {
        return ExampleModel::class;
    }

    /*
    |--------------------------------------------------------------------------
    | ÖZEL SORGULAR
    |--------------------------------------------------------------------------
    | Modele özgü sorguları burada tanımlayın.
    */

    /**
     * Aktif kayıtları getir
     */
    public function getActive(): Collection
    {
        return $this->query()
            ->where('is_active', true)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    /**
     * Kullanıcıya ait kayıtları getir
     */
    public function getByUser(int $userId): Collection
    {
        return $this->query()
            ->where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    /**
     * Arama yap
     */
    public function search(string $term, int $perPage = 15): LengthAwarePaginator
    {
        return $this->query()
            ->where('name', 'like', "%{$term}%")
            ->orderBy('name')
            ->paginate($perPage);
    }

    /**
     * Filtreleme ile sayfalı liste
     *
     * @param array<string, mixed> $filters
     */
    public function getFiltered(array $filters, int $perPage = 15): LengthAwarePaginator
    {
        $query = $this->query();

        if (!empty($filters['user_id'])) {
            $query->where('user_id', $filters['user_id']);
        }

        if (isset($filters['is_active'])) {
            $query->where('is_active', $filters['is_active']);
        }

        if (!empty($filters['search'])) {
            $query->where('name', 'like', "%{$filters['search']}%");
        }

        $sortBy = $filters['sort_by'] ?? 'created_at';
        $sortOrder = $filters['sort_order'] ?? 'desc';
        $query->orderBy($sortBy, $sortOrder);

        return $query->paginate($perPage);
    }

    /**
     * İlişkilerle birlikte getir
     */
    public function findWithRelations(int $id): ?ExampleModel
    {
        return $this->query()
            ->with(['user'])
            ->find($id);
    }

    /**
     * Toplu güncelleme
     *
     * @param array<int> $ids
     * @param array<string, mixed> $data
     */
    public function bulkUpdate(array $ids, array $data): int
    {
        return $this->query()
            ->whereIn('id', $ids)
            ->update($data);
    }

    /**
     * İstatistikler
     *
     * @return array<string, int>
     */
    public function getStats(): array
    {
        return [
            'total' => $this->query()->count(),
            'active' => $this->query()->where('is_active', true)->count(),
            'inactive' => $this->query()->where('is_active', false)->count(),
        ];
    }
}
