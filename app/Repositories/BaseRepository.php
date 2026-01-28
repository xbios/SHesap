<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Repositories\Contracts\BaseRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * BaseRepository
 *
 * Tüm repository'ler için temel implementasyon.
 * Ortak CRUD operasyonlarını sağlar.
 */
abstract class BaseRepository implements BaseRepositoryInterface
{
    /**
     * Repository'nin çalışacağı model
     */
    protected Model $model;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->model = $this->makeModel();
    }

    /**
     * Model sınıfını döndür
     * Alt sınıflar bu metodu implement etmeli
     */
    abstract protected function model(): string;

    /**
     * Model instance'ı oluştur
     */
    protected function makeModel(): Model
    {
        $model = app($this->model());

        if (!$model instanceof Model) {
            throw new \Exception("Class {$this->model()} must be an instance of Illuminate\\Database\\Eloquent\\Model");
        }

        return $model;
    }

    /**
     * Query builder al
     */
    protected function query(): \Illuminate\Database\Eloquent\Builder
    {
        return $this->model->newQuery();
    }

    /**
     * {@inheritDoc}
     */
    public function all(array $columns = ['*']): Collection
    {
        return $this->query()->get($columns);
    }

    /**
     * {@inheritDoc}
     */
    public function find(int|string $id, array $columns = ['*']): ?Model
    {
        return $this->query()->find($id, $columns);
    }

    /**
     * {@inheritDoc}
     */
    public function findOrFail(int|string $id, array $columns = ['*']): Model
    {
        return $this->query()->findOrFail($id, $columns);
    }

    /**
     * {@inheritDoc}
     */
    public function findBy(string $field, mixed $value, array $columns = ['*']): ?Model
    {
        return $this->query()->where($field, $value)->first($columns);
    }

    /**
     * {@inheritDoc}
     */
    public function findAllBy(string $field, mixed $value, array $columns = ['*']): Collection
    {
        return $this->query()->where($field, $value)->get($columns);
    }

    /**
     * {@inheritDoc}
     */
    public function create(array $data): Model
    {
        return $this->query()->create($data);
    }

    /**
     * {@inheritDoc}
     */
    public function update(int|string $id, array $data): bool
    {
        $model = $this->findOrFail($id);

        return $model->update($data);
    }

    /**
     * {@inheritDoc}
     */
    public function delete(int|string $id): bool
    {
        $model = $this->findOrFail($id);

        return (bool) $model->delete();
    }

    /**
     * {@inheritDoc}
     */
    public function paginate(int $perPage = 15, array $columns = ['*']): LengthAwarePaginator
    {
        return $this->query()->paginate($perPage, $columns);
    }

    /**
     * {@inheritDoc}
     */
    public function findWhere(array $criteria, array $columns = ['*']): Collection
    {
        $query = $this->query();

        foreach ($criteria as $key => $value) {
            if (is_array($value)) {
                $query->whereIn($key, $value);
            } else {
                $query->where($key, $value);
            }
        }

        return $query->get($columns);
    }

    /**
     * {@inheritDoc}
     */
    public function count(): int
    {
        return $this->query()->count();
    }

    /**
     * İlişkilerle birlikte sorgu
     *
     * @param array<string> $relations
     */
    public function with(array $relations): static
    {
        $this->model = $this->model->with($relations);

        return $this;
    }

    /**
     * Sıralama ekle
     */
    public function orderBy(string $column, string $direction = 'asc'): static
    {
        $this->model = $this->model->orderBy($column, $direction);

        return $this;
    }
}
