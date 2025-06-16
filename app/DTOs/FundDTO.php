<?php

namespace App\DTOs;

use App\Models\Fund;
use Carbon\Carbon;

readonly class FundDTO
{
    public function __construct(
        public readonly string  $acronym,
        public readonly ?int    $id = null,
        public readonly ?string $name = null,
        public readonly ?string $created_at = null,

    )
    {
    }

    public static function fromRequest(array $data): self
    {
        return new self(
            acronym: $data['acronym'],
            name: $data['name'] ?? null
        );
    }

    public static function fromModel(Fund $fund): self
    {
        return new self(
            acronym: $fund->acronym,
            id: $fund->id ?? null,
            name: $fund->name ?? null,
            created_at: $fund->created_at ? $fund->created_at->format('Y-m-d') : null
        );
    }

    public function getCreatedAt(): ?Carbon
    {
        if ($this->created_at === null) {
            return null;
        }
        return Carbon::createFromFormat('Y-m-d H:i:s', $this->created_at);
    }
}
