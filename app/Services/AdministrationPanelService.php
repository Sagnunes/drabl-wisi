<?php

namespace App\Services;

use App\Interfaces\RoleInterface;
use App\Interfaces\UserRoleInterface;
use App\Interfaces\UserStatusInterface;
use App\Models\User;
use App\UserStatusEnum;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * Class AdministrationPanelService
 *
 * Service for handling administration panel operations.
 */
readonly class AdministrationPanelService
{
    /**
     * AdministrationPanelService constructor.
     *
     * @param UserStatusInterface $userStatusRepository Repository for user status operations
     * @param UserRoleInterface $userRoleRepository Repository for user role operations
     */
    public function __construct(
        private UserStatusInterface $userStatusRepository,
        private UserRoleInterface   $userRoleRepository,
        private RoleInterface       $roleRepository,
    )
    {
    }

    /**
     * Get all users with their relations (status and roles).
     *
     * @return Collection Collection of users with their relations
     * @throws \Exception If there's an error retrieving users
     */
    public function allUserWithRelations(): Collection
    {
        try {
            return User::select(['id', 'name', 'email', 'job_title', 'gov_department', 'status_id'])
                ->with('status:id,name')
                ->with(['roles' => function ($query) {
                    $query->select('roles.id', 'roles.name');
                }])
                ->orderBy('name')->get();
        } catch (\Exception $e) {
            throw new \Exception("Failed to retrieve users with relations: " . $e->getMessage());
        }
    }

    /**
     * Get all roles.
     *
     * @return Collection
     * @throws \Exception If there's an error retrieving roles
     */
    public function getAllRoles(): Collection
    {
        try {
            return $this->roleRepository->all();
        } catch (\Exception $e) {
            throw new \Exception("Failed to retrieve roles: " . $e->getMessage());
        }
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
            $this->userRoleRepository->assignRole($user, $roleId);
        } catch (\Exception $e) {
            throw new \Exception("Failed to assign role to user: " . $e->getMessage());
        }
    }

    /**
     * Assign a role to a user by user ID.
     *
     * @param int $userId The ID of the user to assign the role to
     * @param int $roleId The ID of the role to assign
     * @return void
     * @throws ModelNotFoundException If the user is not found
     * @throws \Exception If there's an error assigning the role
     */
    public function assignRoleById(int $userId, int $roleId): void
    {
        try {
            $user = User::findOrFail($userId);
            $this->assignRole($user, $roleId);
        } catch (ModelNotFoundException $e) {
            throw $e; // Rethrow ModelNotFoundException as is
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
            return $this->userRoleRepository->removeRole($user, $roleId);
        } catch (\Exception $e) {
            throw new \Exception("Failed to remove role from user: " . $e->getMessage());
        }
    }

    /**
     * Remove a role from a user by user ID.
     *
     * @param int $userId The ID of the user to remove the role from
     * @param int $roleId The ID of the role to remove
     * @return bool True if the role was removed, false otherwise
     * @throws ModelNotFoundException If the user is not found
     * @throws \Exception If there's an error removing the role
     */
    public function removeRoleById(int $userId, int $roleId): bool
    {
        try {
            $user = User::findOrFail($userId);
            return $this->removeRole($user, $roleId);
        } catch (ModelNotFoundException $e) {
            throw $e; // Rethrow ModelNotFoundException as is
        } catch (\Exception $e) {
            throw new \Exception("Failed to remove role from user: " . $e->getMessage());
        }
    }

    /**
     * Set the status of a user.
     *
     * @param int $user_id The ID of the user to update
     * @param UserStatusEnum $status The new status
     * @return User The updated user
     * @throws ModelNotFoundException If the user is not found
     * @throws \Exception If there's an error setting the user status
     */
    public function setUserStatus(int $user_id, UserStatusEnum $status): User
    {
        try {
            $user = User::findOrFail($user_id);
            return $this->userStatusRepository->setUserStatus($user, $status);
        } catch (ModelNotFoundException $e) {
            throw $e; // Rethrow ModelNotFoundException as is
        } catch (\Exception $e) {
            throw new \Exception("Failed to set user status: " . $e->getMessage());
        }
    }
}
