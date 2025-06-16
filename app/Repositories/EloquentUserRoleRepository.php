<?php

namespace App\Repositories;

use App\Interfaces\UserRoleInterface;
use App\Models\User;

class EloquentUserRoleRepository implements UserRoleInterface
{
    public function assignRole(User $user, int $roleId): array
    {
        return $user->roles()->sync($roleId);
    }

    public function removeRole(User $user, int $roleId): bool
    {
        return $user->roles()->detach($roleId);
    }
}
