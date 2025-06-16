<?php

namespace App\Services;

use App\DTOs\RoleDTO;
use App\Exceptions\RoleHasUsersException;
use App\Interfaces\RoleInterface;
use App\Models\Role;
use Exception;

readonly class RoleService
{
    public function __construct(
        private RoleInterface $repository
    )
    {
    }

    private function toDto(Role $role): RoleDTO
    {
        return RoleDTO::fromModel($role);
    }

    /**
     * Get all roles as DTOs
     *
     * @return array<RoleDTO>
     * @throws Exception
     */
    public function getAllRoles(): array
    {
        try {
            return $this->repository->all()
                ->map(fn(Role $role) => $this->toDto($role))
                ->toArray();
        } catch (Exception $e) {
            throw new Exception("Failed to retrieve roles: " . $e->getMessage());
        }
    }

    /**
     * Get a role by ID
     *
     * @param int $id
     * @return RoleDTO
     * @throws Exception
     */
    public function getRole(int $id): RoleDTO
    {
        try {
            $role = $this->repository->find($id);
            return $this->toDto($role);
        } catch (Exception $e) {
            throw new Exception("Failed to retrieve role: " . $e->getMessage());
        }
    }

    /**
     * Create a new role
     *
     * @param RoleDTO $dto
     * @return RoleDTO
     * @throws Exception
     */
    public function createRole(RoleDTO $dto): RoleDTO
    {
        try {
            $role = $this->repository->create([
                'name' => $dto->name,
                'description' => $dto->description,
            ]);
            return $this->toDto($role);
        } catch (Exception $e) {
            throw new Exception("Failed to create role: " . $e->getMessage());
        }
    }

    /**
     * Update an existing role
     *
     * @param Role $role
     * @param RoleDTO $dto
     * @return RoleDTO
     * @throws Exception
     */
    public function updateRole(Role $role, RoleDTO $dto): RoleDTO
    {
        try {
            $updatedRole = $this->repository->update($role, [
                'name' => $dto->name,
                'description' => $dto->description,
            ]);
            return $this->toDto($updatedRole);
        } catch (Exception $e) {
            throw new Exception("Failed to update role: " . $e->getMessage());
        }
    }

    /**
     * Delete a role
     *
     * @param Role $role
     * @return bool
     * @throws RoleHasUsersException If the role has users attached
     * @throws Exception If there's an error deleting the role
     */
    public function deleteRole(Role $role): bool
    {
        if ($this->repository->checkIfRolesHaveUsersAttach($role)) {
            throw new RoleHasUsersException("Não é possível eliminar este perfil '{$role->name}' porque tem utilizadores atribuidos.");
        }

        try {
            return $this->repository->delete($role);
        } catch (Exception $e) {
            throw new Exception("Failed to delete role: " . $e->getMessage());
        }
    }
}
