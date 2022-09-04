<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Controllers;

use App\Models\Event;
use App\Models\User;
use Carbon\CarbonImmutable;
use Tests\TestCase;

/**
 * @coversDefaultClass \App\Http\Controllers\EventsController
 */
class EventsControllerTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $this->travelTo('2022-01-01 13:00:00');

        $user = User::factory()->create();
        $this->actingAs($user, 'sanctum');
    }

    /**
     * @covers ::index
     */
    public function testIndexResponseStructure(): void
    {
        Event::factory()->create();

        $this->getJson('api/events')
            ->assertOk()
            ->assertJsonStructure([
                [
                    'id',
                    'created_at',
                    'updated_at',
                    'valid_from',
                    'valid_to',
                    'title',
                    'description',
                ],
            ]);
    }

    /**
     * @covers ::index
     * @dataProvider indexDataProvider
     */
    public function testIndex(bool $returnedEvent, string $validFrom, null|string $validTo): void
    {
        Event::factory()->create([
            'valid_from' => CarbonImmutable::parse($validFrom),
            'valid_to' => CarbonImmutable::parse($validTo),
        ]);

        $this->getJson('api/events')
            ->assertOk()
            ->assertJsonCount($returnedEvent ? 1 : 0);
    }

    /**
     * @return array<int, array<int, null|bool|string>>
     */
    public function indexDataProvider(): array
    {
        return [
            [true, '2022-01-01 12:00:00', '2022-01-01 13:00:00'],
            [true, '2022-01-01 12:00:00', null],
            [true, '2021-12-01 12:00:00', null],
            [false, '2022-01-02 12:00:00', '2022-01-02 13:00:00'],
            [false, '2021-12-31 12:00:00', '2021-12-31 13:00:00'],
        ];
    }

    /**
     * @covers ::store
     */
    public function testStore(): void
    {
        $this->assertDatabaseCount(Event::class, 0);

        $this->postJson(
            'api/events',
            [
                'title' => 'Test',
                'description' => 'Test description',
                'valid_from' => CarbonImmutable::now()->toIso8601String(),
                'valid_to' => null,
            ]
        )
            ->assertCreated()
            ->assertJsonStructure([
                'id',
                'created_at',
                'updated_at',
                'valid_from',
                'valid_to',
                'title',
                'description',
            ]);

        $this->assertDatabaseCount(Event::class, 1);
    }

    /**
     * @covers ::update
     */
    public function testUpdate(): void
    {
        $originalEvent = Event::factory()->create();

        $updatedEvent = [
            'title' => 'Test',
            'description' => 'Test description',
            'valid_from' => CarbonImmutable::now()->addDay()->toIso8601String(),
            'valid_to' => null,
        ];

        $this->putJson(
            "api/events/{$originalEvent->id}",
            $updatedEvent
        )
            ->assertOk()
            ->assertJsonStructure([
                'id',
                'created_at',
                'updated_at',
                'valid_from',
                'valid_to',
                'title',
                'description',
            ]);

        $this->assertDatabaseHas(
            Event::class,
            [
                'id' => $originalEvent->id,
                'title' => $updatedEvent['title'],
                'description' => $updatedEvent['description'],
                'valid_from' => CarbonImmutable::parse($updatedEvent['valid_from'])->toDateTimeString(),
                'valid_to' => $updatedEvent['valid_to'],
            ]
        );
    }

    /**
     * @covers ::delete
     */
    public function testDelete(): void
    {
        $event = Event::factory()->create();

        $this->assertDatabaseCount(Event::class, 1);

        $this->deleteJson("api/events/{$event->id}")
            ->assertNoContent();

        $this->assertDatabaseCount(Event::class, 0);
    }
}
