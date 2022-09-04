<?php

declare(strict_types=1);

namespace App\Contracts\Repositories;

use App\Http\RequestsData\EventStoreRequestData;
use App\Http\RequestsData\EventUpdateRequestData;
use App\Http\ResponsesData\EventResponseData;
use Spatie\LaravelData\DataCollection;

interface EventRepositoryInterface
{
    /**
     * @return DataCollection<int, EventResponseData>
     */
    public function list(): DataCollection;

    public function get(int $eventId): EventResponseData;

    public function create(EventStoreRequestData $eventRequestData): EventResponseData;

    public function update(EventUpdateRequestData $eventRequestData): EventResponseData;

    public function delete(int $eventId): void;
}
