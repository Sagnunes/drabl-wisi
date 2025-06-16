<?php

namespace App\Repositories;

use App\Interfaces\DigitalCollectionInterface;
use App\Models\DigitalObject;
use App\Models\Fund;
use Illuminate\Database\Eloquent\Collection;

class EloquentDigitalCollectionRepository implements DigitalCollectionInterface
{

    public function getFundsWithOneDigitalObject(): Collection
    {
        return Fund::with(['digitalObjects' => function ($query) {
            $query->select('fund_id', 'image_thumb', 'image_name', 'id')
                ->whereNotNull('image_thumb')
                ->orderByRaw('RANDOM()')
                ->limit(1);
        }])->orderBy('acronym')->get();
    }

    public function getDigitalCollectionByFund(Fund $fund, ?string $search = null)
    {
        return DigitalObject::withFund($fund)
            ->when($search, fn($q) => $q->withSearch($search, $fund->id))
            ->ordered();
    }
}
