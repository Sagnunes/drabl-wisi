<?php

namespace App\DTOs;

use App\Models\Status;
use Carbon\Carbon;

readonly class StatusDTO
{
    public function __construct(
        public readonly string  $name,
        public readonly ?int    $id = null,
        public readonly ?string $description = null,
        public readonly ?string $created_at = null,
    )
    {
    }

    public static function fromRequest(array $data): self
    {
        return new self(
            name: $data['name'],
            description: $data['description'] ?? null
        );
    }

    public static function fromModel(Status $status): self
    {
        return new self(
            name: $status->name,
            id: $status->id ?? null,
            description: $status->description,
            created_at: $status->created_at ? $status->created_at->format('Y-m-d') : null,
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
