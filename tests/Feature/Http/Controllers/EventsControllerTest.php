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
     * @covers ::test
     */
    public function testTest(): void
    {
        $response = $this->getJson('api/test');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'test'
        ]);
    }
}
