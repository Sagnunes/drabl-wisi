<?php

namespace App\Services;

use App\Interfaces\DigitalCollectionInterface;
use App\Models\Fund;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

readonly class DigitalCollectionService
{
    /**
     * DigitalCollectionService constructor
     *
     * @param DigitalCollectionInterface $repository
     */
    public function __construct(
        private DigitalCollectionInterface $repository
    )
    {
    }

    /**
     * Retrieves digital collection funds
     *
     * @return Collection
     */
    public function getDigitalCollectionFunds(): Collection
    {
        return $this->repository->getFundsWithOneDigitalObject();
    }

    /**
     * Retrieves paginated digital objects related to a specific fund based on search criteria.
     *
     * @param Fund $fund The fund entity used to filter digital objects.
     * @param mixed $search The search parameter for filtering the digital objects.
     * @return LengthAwarePaginator Paginated list of digital objects.
     */
    public function getDigitalObjectsByFund(Fund $fund, $search): LengthAwarePaginator
    {
        return $this->repository->getDigitalCollectionByFund($fund, $search)->paginate(10)->withQueryString();
    }
}
