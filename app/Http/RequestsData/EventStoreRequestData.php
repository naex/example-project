<?php

declare(strict_types=1);

namespace App\Http\RequestsData;

use Carbon\CarbonImmutable;
use Carbon\CarbonInterface;
use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Attributes\Validation\Rule;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\Casts\DateTimeInterfaceCast;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

#[MapName(SnakeCaseMapper::class)]
class EventStoreRequestData extends Data
{
    public function __construct(
        #[Rule(['max:255'])]
        public readonly string $title,
        public readonly string $description,
        #[WithCast(DateTimeInterfaceCast::class, type: CarbonImmutable::class)]
        public readonly CarbonInterface $validFrom,
        #[Rule(['after:valid_from'])]
        #[WithCast(DateTimeInterfaceCast::class, type: CarbonImmutable::class)]
        public readonly null|CarbonInterface $validTo,
    ) {
    }
}
