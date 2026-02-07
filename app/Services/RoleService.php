<?php

namespace App\Services;

use App\Repositories\RoleRepository;
use Illuminate\Support\Facades\DB;

class RoleService extends BaseService
{
    public function __construct(RoleRepository $repository)
    {
        parent::__construct($repository);
    }

    public function createRole(array $data)
    {
        return DB::transaction(function () use ($data) {
            $permissionIds = $data['permissions'] ?? [];
            unset($data['permissions']);

            $role = $this->repository->create($data);

            if (!empty($permissionIds)) {
                $role->permissions()->sync($permissionIds);
            }

            return $role;
        });
    }

    public function updateRole($id, array $data)
    {
        return DB::transaction(function () use ($id, $data) {
            $permissionIds = $data['permissions'] ?? [];
            unset($data['permissions']);

            $this->repository->update($id, $data);
            
            $role = $this->repository->find($id);
            if ($role) {
                $role->permissions()->sync($permissionIds);
            }

            return $role;
        });
    }
}
