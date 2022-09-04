<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Contracts\Repositories\EventRepositoryInterface;
use App\Http\RequestsData\EventStoreRequestData;
use App\Http\RequestsData\EventUpdateRequestData;
use App\Models\Event;
use Carbon\CarbonImmutable;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class EventsController
{
    public function __construct(
        private readonly EventRepositoryInterface $repository
    ) {
    }

    public function index(): JsonResponse
    {
        $eventResponses = $this->repository->list();

        return new JsonResponse(data: $eventResponses);
    }

    public function show(int $eventId): JsonResponse
    {
        $eventResponse = $this->repository->get($eventId);

        return new JsonResponse(data: $eventResponse);
    }

    public function store(EventStoreRequestData $eventRequestData): JsonResponse
    {
        $eventResponse = $this->repository->create($eventRequestData);

        return new JsonResponse(data: $eventResponse, status: Response::HTTP_CREATED);
    }

    public function update(EventUpdateRequestData $eventRequestData): JsonResponse
    {
        $event = Event::query()
            ->where('id', $eventRequestData->id)
            ->firstOrFail();
        assert($event instanceof Event);

        $event->update($eventRequestData->toArray());

        return new JsonResponse($event->toArray());
    }

    public function delete(int $eventId): JsonResponse
    {
        $this->repository->delete($eventId);

        return new JsonResponse(status: Response::HTTP_NO_CONTENT);
    }
}
