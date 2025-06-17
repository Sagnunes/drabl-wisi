<?php

namespace App\Interfaces;

use App\Models\User;
use App\UserStatusEnum;

interface UserStatusInterface
{
    public function setUserStatus(User $user, UserStatusEnum $status);
}
