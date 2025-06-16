<?php

namespace App\Repositories;

use App\Interfaces\StatusInterface;
use App\Models\Status;
use Illuminate\Database\Eloquent\Collection;

class EloquentStatusRepository implements StatusInterface
{
    /**
     * The columns to select from the funds table
     */
    private const STATUS_LIST_COLUMNS = ['id', 'name', 'description', 'created_at', 'updated_at'];

    public function all(): Collection
    {
        return Status::query()->select(self::STATUS_LIST_COLUMNS)->orderBy('name')->get();
    }

    public function find(int $id): Status
    {
        return Status::query()->select(self::STATUS_LIST_COLUMNS)->findOrFail($id);
    }

    public function create(array $data): Status
    {
        return Status::query()->create($data);
    }

    public function update(Status $status, array $data): Status
    {
        $status->update($data);
        return $status->fresh();
    }

    public function delete(Status $status): bool
    {
        return $status->delete();
    }
}
