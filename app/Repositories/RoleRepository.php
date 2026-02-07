<?php

namespace App\Repositories;

use App\Models\Role;

class RoleRepository extends BaseRepository
{
    protected function model(): string
    {
        return Role::class;
    }

    public function getWithPermissions()
    {
        return $this->query()->with('permissions')->get();
    }
}
