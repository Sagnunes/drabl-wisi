<?php

namespace App\Services;

use App\Interfaces\DigitalCollectionInterface;
use App\Models\Fund;

class DigitalCollectionService
{
    public function __construct(
        private DigitalCollectionInterface $repository
    )
    {
    }

    public function getDigitalCollectionFunds()
    {
        return $this->repository->getFundsWithOneDigitalObject();
    }

    public function getDigitalObjectsByFund(Fund $fund, $search)
    {
        return $this->repository->getDigitalCollectionByFund($fund, $search)->paginate(10)->withQueryString();
    }
}
