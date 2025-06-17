<?php

namespace App\Interfaces;

use App\Models\Role;
use App\Models\User;

/**
 * Interface UserRoleInterface
 *
 * Interface for user role operations.
 */
interface UserRoleInterface
{
    /**
     * Assign a role to a user.
     *
     * @param User $user The user to assign the role to
     * @param int $roleId The ID of the role to assign
     * @return array Array with information about the sync operation
     */
    public function assignRole(User $user, int $roleId): array;

    /**
     * Remove a role from a user.
     *
     * @param User $user The user to remove the role from
     * @param int $roleId The ID of the role to remove
     * @return bool True if the role was removed, false otherwise
     */
    public function removeRole(User $user, int $roleId): bool;

    /**
     * Check if a role has any users attached.
     *
     * @param Role $role The role to check
     * @return bool True if the role has users attached, false otherwise
     */
    public function checkIfRolesHaveUsersAttach(Role $role): bool;
}
