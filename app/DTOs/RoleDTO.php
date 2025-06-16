<?php

namespace App\DTOs;

use App\Models\Role;
use Carbon\Carbon;

readonly class RoleDTO
{
    public function __construct(
        public readonly string  $name,
        public readonly ?int    $id = null,
        public readonly ?string $description = null,
        public readonly ?string $created_at = null,
        public readonly ?array  $users = null
    )
    {
    }

    public static function fromRequest(array $data): self
    {
        return new self(
            name: $data['name'],
            description: $data['description'] ?? null
        );
    }

    public static function fromModel(Role $role): self
    {
        return new self(
            id: $role->id ?? null,
            name: $role->name,
            description: $role->description,
            created_at: $role->created_at ? $role->created_at->format('Y-m-d') : null,
            users: $role->users ? $role->users->pluck('name')->toArray() : null
        );
    }

    public function getCreatedAt(): ?Carbon
    {
        if ($this->created_at === null) {
            return null;
        }
        return Carbon::createFromFormat('Y-m-d H:i:s', $this->created_at);
    }
}
