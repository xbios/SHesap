<?php

namespace App\Repositories;

use App\Models\ActivityLog;
use Illuminate\Pagination\LengthAwarePaginator;

class ActivityLogRepository extends BaseRepository
{
    protected function model(): string
    {
        return ActivityLog::class;
    }

    public function getFiltered(array $filters, int $perPage = 15): LengthAwarePaginator
    {
        $query = $this->query()->with('user');

        if (!empty($filters['user_id'])) {
            $query->where('user_id', $filters['user_id']);
        }

        if (!empty($filters['action'])) {
            $query->where('action', $filters['action']);
        }

        if (!empty($filters['model_type'])) {
            $query->where('model_type', 'like', "%{$filters['model_type']}%");
        }

        return $query->latest()->paginate($perPage);
    }
}
