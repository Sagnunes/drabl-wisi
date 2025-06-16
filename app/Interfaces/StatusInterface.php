<?php

namespace App\Interfaces;
use App\Models\Status;
use Illuminate\Database\Eloquent\Collection;

interface StatusInterface
{
    public function all(): Collection;

    public function find(int $id): Status;

    public function create(array $data): Status;

    public function update(Status $status, array $data): Status;

    public function delete(Status $status): bool;
}
