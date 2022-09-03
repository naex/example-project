<?php
declare(strict_types=1);

namespace Tests\Feature\Http\Controllers;

use App\Models\User;
use Tests\TestCase;

/**
 * @coversDefaultClass \App\Http\Controllers\EventsController
 */
class EventsControllerTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $user = User::factory()->create();

        $this->actingAs($user, 'sanctum');
    }

    /**
     * @covers ::index
     */
    public function testIndex(): void
    {
        $this->getJson('api/events')
            ->assertOk()
            ->assertJsonStructure([
                'index'
            ]);
    }
}
