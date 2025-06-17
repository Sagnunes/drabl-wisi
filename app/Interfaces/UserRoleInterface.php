<?php

namespace App\Interfaces;

use App\Models\Role;
use App\Models\User;

interface UserRoleInterface
{
    public function assignRole(User $user, int $roleId): array;

    public function removeRole(User $user, int $roleId): bool;

    public function checkIfRolesHaveUsersAttach(Role $role): bool;

}
