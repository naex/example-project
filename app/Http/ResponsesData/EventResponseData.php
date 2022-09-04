<?php

declare(strict_types=1);

namespace App\Http\ResponsesData;

use Carbon\CarbonInterface;
use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

#[MapName(SnakeCaseMapper::class)]
class EventResponseData extends Data
{
    public function __construct(
        public readonly int $id,
        public readonly string $title,
        public readonly string $description,
        public readonly CarbonInterface $validFrom,
        public readonly null|CarbonInterface $validTo,
        public readonly CarbonInterface $createdAt,
        public readonly null|CarbonInterface $updatedAt,
    ) {
    }
}
