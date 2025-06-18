<?php

namespace App;

enum UserStatusEnum: int
{
    case PENDING = 1;
    case ACTIVE = 2;
    case SUSPENDED = 3;

    public function getName(): string
    {
        return match ($this) {
            self::PENDING => 'Pendente',
            self::ACTIVE => 'Ativo',
            self::SUSPENDED => 'Suspenso',
        };
    }

    public static function fromName(string $name): ?self
    {
        foreach (self::cases() as $case) {
            if ($case->getName() === $name) {
                return $case;
            }
        }
        return null;
    }
}
