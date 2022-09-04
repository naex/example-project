<?php

declare(strict_types=1);

namespace App\Http\Repositories\Eloquent;

use App\Contracts\Repositories\EventRepositoryInterface;
use App\Http\RequestsData\EventStoreRequestData;
use App\Http\RequestsData\EventUpdateRequestData;
use App\Http\ResponsesData\EventResponseData;
use App\Models\Event;
use Carbon\CarbonImmutable;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Spatie\LaravelData\DataCollection;

class EventRepository implements EventRepositoryInterface
{
    /**
     * @inheritDoc
     */
    public function list(): DataCollection
    {
        $events = Event::query()
            ->whereDate('valid_from', '<=', CarbonImmutable::now())
            ->where(
                fn(Builder $query) => $query
                    ->whereNull('valid_to')
                    ->orWhereDate('valid_to', '>=', CarbonImmutable::now())
            )
            ->get();

        return EventResponseData::collection($events);
    }

    public function get(int $eventId): EventResponseData
    {
        $event = Event::query()
            ->where('id', $eventId)
            ->firstOrFail();

        return EventResponseData::from($event);
    }

    public function create(EventStoreRequestData $eventRequestData): EventResponseData
    {
        $event = Event::query()->create($eventRequestData->toArray());
        assert($event instanceof Event);

        return EventResponseData::from($event);
    }

    public function update(EventUpdateRequestData $eventRequestData): EventResponseData
    {
        $event = Event::query()
            ->where('id', $eventRequestData->id)
            ->firstOrFail();
        assert($event instanceof Event);

        $event->update($eventRequestData->toArray());

        return EventResponseData::from($event);
    }

    public function delete(int $eventId): void
    {
        Event::query()
            ->where('id', $eventId)
            ->delete();
    }
}
