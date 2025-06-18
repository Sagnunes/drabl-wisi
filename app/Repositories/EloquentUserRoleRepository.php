<?php

namespace App\Repositories;

use App\Interfaces\UserRoleInterface;
use App\Models\Role;
use App\Models\User;

class EloquentUserRoleRepository implements UserRoleInterface
{
    public function assignRole(User $user, int $roleId): void
    {
        $user->roles()->attach($roleId);
    }

    public function removeRole(User $user, int $roleId): bool
    {
        return $user->roles()->detach($roleId);
    }


    public function checkIfRolesHaveUsersAttach(Role $role): bool
    {
        return $role->users()->exists();
    }
}
