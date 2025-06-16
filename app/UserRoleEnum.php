<?php

namespace App;

enum UserRoleEnum: int
{
    /**
     * Role constants.
     *
     */
    case ADMIN = 1;
    case DIGITAL_COLLECTION = 2;

    public function getName(): string
    {
        return match ($this) {
            self::ADMIN => 'Administrador',
            self::DIGITAL_COLLECTION => 'Coleção Digital2',
        };
    }
}
