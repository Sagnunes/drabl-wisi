<?php

namespace App\Repositories;

use App\Interfaces\RoleInterface;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class EloquentRoleRepository implements RoleInterface
{
    /**
     * The columns to select from the roles table
     */
    private const ROLE_LIST_COLUMNS = ['id', 'name', 'description', 'created_at', 'updated_at'];

    public function all(): Collection
    {
        return Role::query()->select(self::ROLE_LIST_COLUMNS)->orderBy('name')->get();
    }

    public function find(int $id): Role
    {
        return Role::query()->select(self::ROLE_LIST_COLUMNS)->findOrFail($id);
    }

    public function create(array $data): Role
    {
        return Role::query()->create($data);
    }

    public function update(Role $role, array $data): Role
    {
        $role->update($data);
        return $role->fresh();
    }

    public function delete(Role $role): bool
    {
        return $role->delete();
    }

    public function checkIfRolesHaveUsersAttach(Role $role): bool
    {
        return $role->users()->exists();
    }
}
