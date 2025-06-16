<?php

namespace App\Interfaces;


use App\Models\Fund;
use Illuminate\Database\Eloquent\Collection;

interface FundInterface
{
    public function all(): Collection;

    public function find(int $id): Fund;

    public function create(array $data): Fund;

    public function update(Fund $fund, array $data): Fund;

    public function delete(Fund $fund): bool;
}
