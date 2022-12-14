<?php

declare(strict_types=1);

namespace App\Http\RequestsData;

use App\Contracts\EventDataInterface;
use Carbon\CarbonImmutable;
use Carbon\CarbonInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Attributes\Validation\Rule;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\Casts\DateTimeInterfaceCast;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

#[MapName(SnakeCaseMapper::class)]
class EventUpdateRequestData extends Data implements EventDataInterface
{
    public function __construct(
        public readonly int $id,
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

    /**
     * @param Request $payloads
     */
    public static function from(...$payloads): static
    {
        $request = Arr::first($payloads);
        assert($request instanceof Request);

        $request->mergeIfMissing([
            'id' => $request->route('eventId')
        ]);

        return parent::from($request);
    }
}
