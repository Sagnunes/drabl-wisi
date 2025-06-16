<?php

namespace App\Interfaces;

use App\Models\Fund;

interface DigitalCollectionInterface
{
    public function getFundsWithOneDigitalObject();

    public function getDigitalCollectionByFund(Fund $fund);
}
