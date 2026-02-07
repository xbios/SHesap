<?php

namespace App\Services;

use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserService extends BaseService
{
    public function __construct(UserRepository $repository)
    {
        parent::__construct($repository);
    }

    public function createUser(array $data)
    {
        return DB::transaction(function () use ($data) {
            $roleIds = $data['roles'] ?? [];
            unset($data['roles']);

            $data['password'] = Hash::make($data['password']);
            $user = $this->repository->create($data);

            if (!empty($roleIds)) {
                $user->roles()->sync($roleIds);
            }

            return $user;
        });
    }

    public function updateUser($id, array $data)
    {
        return DB::transaction(function () use ($id, $data) {
            $roleIds = $data['roles'] ?? [];
            unset($data['roles']);

            if (!empty($data['password'])) {
                $data['password'] = Hash::make($data['password']);
            } else {
                unset($data['password']);
            }

            $user = $this->repository->update($id, $data);
            
            // Re-fetch user to sync roles
            $userModel = $this->repository->find($id);
            if ($userModel && !empty($roleIds)) {
                $userModel->roles()->sync($roleIds);
            }

            return $user;
        });
    }
}
