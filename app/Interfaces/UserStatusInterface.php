<?php

namespace App\Interfaces;

use App\Models\User;
use App\UserStatusEnum;

/**
 * Interface UserStatusInterface
 *
 * Interface for user status operations.
 */
interface UserStatusInterface
{
    /**
     * Set the status of a user.
     *
     * @param User $user The user to update
     * @param UserStatusEnum $status The new status
     * @return User The updated user
     */
    public function setUserStatus(User $user, UserStatusEnum $status): User;
}
