<?php

namespace App\Interfaces;

use App\Models\Fund;
use Illuminate\Database\Eloquent\Collection;

interface DigitalCollectionInterface
{
    public function getFundsWithOneDigitalObject(): Collection;

    public function getDigitalCollectionByFund(Fund $fund): Collection;
}
