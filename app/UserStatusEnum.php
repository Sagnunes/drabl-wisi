<?php

namespace App;

enum UserStatusEnum: int
{
    case PENDING = 1;
    case APPROVED = 2;
    case REJECTED = 3;
    case SUSPENDED = 4;

    public function getName(): string
    {
        return match ($this) {
            self::PENDING => 'Pendente',
            self::APPROVED => 'Aprovado',
            self::REJECTED => 'Rejeitado',
            self::SUSPENDED => 'Suspenso',
        };
    }
}
