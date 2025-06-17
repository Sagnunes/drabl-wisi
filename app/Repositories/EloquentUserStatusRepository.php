<?php

namespace App\Repositories;

use App\Interfaces\UserStatusInterface;
use App\Models\User;
use App\UserStatusEnum;

class EloquentUserStatusRepository implements UserStatusInterface
{
    public function setUserStatus(User $user, UserStatusEnum $status): User
    {
        return $user->setStatus($status->value);
    }
}
