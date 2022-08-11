<?php
declare(strict_types=1);

namespace Tests\Feature\Http\Controllers;

use Tests\TestCase;

/**
 * @coversDefaultClass \App\Http\Controllers\EventsController
 */
class EventsControllerTest extends TestCase
{
    /**
     * @covers ::index
     */
    public function testTest(): void
    {
        $this->getJson('api/events')
            ->assertOk()
            ->assertJsonStructure([
                'index'
            ]);
    }
}
