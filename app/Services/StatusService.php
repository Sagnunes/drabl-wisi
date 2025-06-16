<?php

namespace App\Services;

use App\DTOs\StatusDTO;
use App\Interfaces\StatusInterface;
use App\Models\Status;
use Exception;

class StatusService
{
    public function __construct(
        private StatusInterface $repository
    )
    {
    }

    private function toDto(Status $status): StatusDTO
    {
        return StatusDTO::fromModel($status);
    }

    /**
     * @return array<StatusDTO>
     * @throws Exception
     */
    public function getAllStatus(): array
    {
        try {
            return $this->repository->all()
                ->map(fn(Status $status) => $this->toDto($status))
                ->toArray();
        } catch (Exception $e) {
            throw new Exception("Failed to retrieve status: " . $e->getMessage());
        }
    }

    /**
     * @param int $id
     * @return StatusDTO
     * @throws Exception
     */
    public function getStatus(int $id): StatusDTO
    {
        try {
            $status = $this->repository->find($id);
            return $this->toDto($status);
        } catch (Exception $e) {
            throw new Exception("Failed to retrieve status: " . $e->getMessage());
        }

    }

    /**
     * @param StatusDTO $dto
     * @return StatusDTO
     * @throws Exception
     */
    public function createStatus(StatusDTO $dto): StatusDTO
    {
        try {
            $role = $this->repository->create([
                'name' => $dto->name,
                'description' => $dto->description,
            ]);
            return $this->toDto($role);
        } catch (Exception $e) {
            throw new Exception("Failed to create status: " . $e->getMessage());
        }
    }

    /**
     * @param Status $status
     * @param StatusDTO $dto
     * @return StatusDTO
     * @throws Exception
     */
    public function updateStatus(Status $status, StatusDTO $dto): StatusDTO
    {
        try {
            $updatedStatus = $this->repository->update($status, [
                'name' => $dto->name,
                'description' => $dto->description,
            ]);
            return $this->toDto($updatedStatus);
        } catch (Exception $e) {
            throw new Exception("Failed to update status: " . $e->getMessage());
        }
    }

    /**
     * @param Status $status
     * @return bool
     * @throws Exception
     */
    public function deleteStatus(Status $status): bool
    {
        try {
            return $this->repository->delete($status);
        } catch (Exception $e) {
            throw new Exception("Failed to delete status: " . $e->getMessage());
        }
    }
}
