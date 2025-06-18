<?php

namespace App\Services;

use App\Interfaces\UserRoleInterface;
use App\Models\User;

readonly class UserRoleService
{
    public function __construct(private UserRoleInterface $repository)
    {
    }

    /**
     * Assign a role to a user.
     *
     * @param User $user The user to assign the role to
     * @param int $roleId The ID of the role to assign
     * @return void
     * @throws \Exception If there's an error assigning the role
     */
    public function assignRole(User $user, int $roleId): void
    {
        try {
            $this->repository->assignRole($user, $roleId);
        } catch (\Exception $e) {
            throw new \Exception("Failed to assign role to user: " . $e->getMessage());
        }
    }

    /**
     * Remove a role from a user.
     *
     * @param User $user The user to remove the role from
     * @param int $roleId The ID of the role to remove
     * @return bool True if the role was removed, false otherwise
     * @throws \Exception If there's an error removing the role
     */
    public function removeRole(User $user, int $roleId): bool
    {
        try {
            return $this->repository->removeRole($user, $roleId);
        } catch (\Exception $e) {
            throw new \Exception("Failed to remove role from user: " . $e->getMessage());
        }
    }
}
