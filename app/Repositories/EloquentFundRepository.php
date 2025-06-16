<?php

namespace App\Repositories;

use App\Interfaces\FundInterface;
use App\Models\Fund;
use Illuminate\Database\Eloquent\Collection;

class EloquentFundRepository implements FundInterface
{

    /**
     * The columns to select from the funds table
     */
    private const FUND_LIST_COLUMNS = ['id', 'name', 'acronym', 'created_at', 'updated_at'];

    public function all(): Collection
    {
        return Fund::query()->select(self::FUND_LIST_COLUMNS)->orderBy('acronym')->get();
    }

    public function find(int $id): Fund
    {
        return Fund::query()->select(self::FUND_LIST_COLUMNS)->findOrFail($id);
    }

    public function create(array $data): Fund
    {
        return Fund::query()->create($data);
    }

    public function update(Fund $fund, array $data): Fund
    {
        $fund->update($data);
        return $fund->fresh();
    }

    public function delete(Fund $fund): bool
    {
        return $fund->delete();
    }
}
