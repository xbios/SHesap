<?php

namespace App\Repositories;

use App\Models\Setting;

class SettingRepository extends BaseRepository
{
    protected function model(): string
    {
        return Setting::class;
    }

    public function getByGroup(string $group)
    {
        return $this->query()->where('group', $group)->get();
    }

    public function getAllGrouped()
    {
        return $this->query()->get()->groupBy('group');
    }
}
