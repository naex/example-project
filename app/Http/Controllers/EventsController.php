<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\RequestsData\EventStoreRequestData;
use App\Models\Event;
use Carbon\CarbonImmutable;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class EventsController
{
    public function index(): JsonResponse
    {
        $events = Event::query()
            ->whereDate('valid_from', '<=', CarbonImmutable::now())
            ->where(
                fn(Builder $query) => $query
                    ->whereNull('valid_to')
                    ->orWhereDate('valid_to', '>=', CarbonImmutable::now())
            )
            ->get();

        return new JsonResponse($events->toArray());
    }

    public function store(EventStoreRequestData $eventRequestData): JsonResponse
    {
        $event = Event::query()->create($eventRequestData->toArray());
        assert($event instanceof Event);

        return new JsonResponse($event->toArray(), Response::HTTP_CREATED);
    }

    public function delete(int $eventId): JsonResponse
    {
        Event::query()
            ->where('id', $eventId)
            ->delete();

        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }
}
