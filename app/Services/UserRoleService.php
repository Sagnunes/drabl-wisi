<?php

namespace App\Services;

use App\Interfaces\UserRoleInterface;
use App\Models\User;

readonly class UserRoleService
{
    public function __construct(private UserRoleInterface $repository)
    {
    }

    public function assignRole(User $user, int $roleId): array
    {
        return $this->repository->assignRole($user, $roleId);
    }

    public function removeRole(User $user, int $roleId): bool
    {
        return $this->repository->removeRole($user, $roleId);
    }
}
