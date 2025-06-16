<?php

namespace App\Services;

use App\DTOs\FundDTO;
use App\Interfaces\FundInterface;
use Exception;
use App\Models\Fund;

readonly class FundService
{
    public function __construct(
        private FundInterface $repository
    )
    {
    }

    private function toDto(Fund $fund): FundDTO
    {
        return FundDTO::fromModel($fund);
    }

    /**
     * Get all roles as DTOs
     *
     * @return array<FundDTO>
     * @throws Exception
     */
    public function getAllFunds(): array
    {
        try {
            return $this->repository->all()
                ->map(fn(Fund $fund) => $this->toDto($fund))
                ->toArray();
        } catch (Exception $e) {
            throw new Exception("Failed to retrieve roles: " . $e->getMessage());
        }
    }

    /**
     * Get a role by ID
     *
     * @param int $id
     * @return FundDTO
     * @throws Exception
     */
    public function getFund(int $id): FundDTO
    {
        try {
            $fund = $this->repository->find($id);
            return $this->toDto($fund);
        } catch (Exception $e) {
            throw new Exception("Failed to retrieve role: " . $e->getMessage());
        }
    }

    /**
     * Create a new role
     *
     * @param FundDTO $dto
     * @return FundDTO
     * @throws Exception
     */
    public function createFund(FundDTO $dto): FundDTO
    {
        try {
            $fund = $this->repository->create([
                'name' => $dto->name,
                'acronym' => $dto->acronym,
            ]);
            return $this->toDto($fund);
        } catch (Exception $e) {
            throw new Exception("Failed to create role: " . $e->getMessage());
        }
    }

    /**
     * Update an existing role
     *
     * @param Fund $fund
     * @param FundDTO $dto
     * @return FundDTO
     * @throws Exception
     */
    public function updateFund(Fund $fund, FundDTO $dto): FundDTO
    {
        try {
            $updatedFund = $this->repository->update($fund, [
                'name' => $dto->name,
                'acronym' => $dto->acronym,
            ]);
            return $this->toDto($updatedFund);
        } catch (Exception $e) {
            throw new Exception("Failed to update role: " . $e->getMessage());
        }
    }

    /**
     * Delete a role
     *
     * @param Fund $fund
     * @return bool
     * @throws Exception If there's an error, deleting the role
     */
    public function deleteFund(Fund $fund): bool
    {
        try {
            return $this->repository->delete($fund);
        } catch (Exception $e) {
            throw new Exception("Failed to delete role: " . $e->getMessage());
        }
    }
}
