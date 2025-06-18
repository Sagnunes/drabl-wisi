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
     */
    public function allUserWithRelations(): Collection
    {
        return User::select(['id', 'name', 'email', 'job_title', 'gov_department', 'status_id'])
            ->with('status:id,name')
            ->with(['roles' => function ($query) {
                $query->select('roles.id', 'roles.name');
            }])
            ->orderBy('name')->get();
    }

    /**
     * Get all roles.
     *
     * @return Collection
     */
    public function getAllRoles(): Collection
    {
        return $this->roleRepository->all();
    }

    /**
     * Assign a role to a user.
     *
     * @param User $user The user to assign the role to
     * @param int $role_id The ID of the role to assign
     * @return array Array with information about the sync operation
     */
    public function assignRoleToUser(User $user, int $role_id): void
    {
       $this->userRoleRepository->assignRole($user, $role_id);
    }

    /**
     * Revoke a role from a user.
     *
     * @param User $user The user to revoke the role from
     * @param int $role_id The ID of the role to revoke
     * @return bool True if the role was revoked, false otherwise
     */
    public function revokeRoleFromUser(User $user, int $role_id): bool
    {
        return $this->userRoleRepository->removeRole($user, $role_id);
    }

    /**
     * Set the status of a user.
     *
     * @param int $user_id The ID of the user to update
     * @param UserStatusEnum $status The new status
     * @return User The updated user
     * @throws ModelNotFoundException If the user is not found
     */
    public function setUserStatus(int $user_id, UserStatusEnum $status): User
    {
        $user = User::findOrFail($user_id);
        return $this->userStatusRepository->setUserStatus($user, $status);
    }
}
