<?php

namespace App\Services;

use App\Interfaces\UserRoleInterface;
use App\Interfaces\UserStatusInterface;
use App\Models\User;
use App\UserStatusEnum;

readonly class AdministrationPanelService
{
    public function __construct(
        private UserStatusInterface $userStatusRepository,
        private UserRoleInterface   $userRoleRepository,
    )
    {
    }

    public function allUserWithRelations()
    {
        return User::select(['id', 'name', 'email', 'job_title', 'gov_department', 'status_id'])
            ->with('status:id,name')
            ->with(['roles' => function ($query) {
                $query->select('roles.id', 'roles.name');
            }])
            ->orderBy('name')->get();
    }

    public function assignRoleToUser(User $user, $role_id): array
    {
        return $this->userRoleRepository->assignRole($user, $role_id);
    }

    public function revokeRoleFromUser(User $user, $role_id): bool
    {
        return $this->userRoleRepository->removeRole($user, $role_id);
    }

    public function setUserStatus($user_id, UserStatusEnum $status)
    {
        $user = User::where('id', $user_id)->first();
        return $this->userStatusRepository->setUserStatus($user, $status);
    }
}
