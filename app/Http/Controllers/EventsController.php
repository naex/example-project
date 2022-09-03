<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;

class EventsController
{
    public function __construct()
    {
        // TODO: inject events repository
    }

    public function index(): JsonResponse
    {
        // TODO: call repository
        // Event model
        // Tests for each layer
        // TODO: Add DTOs for request, response and domain DTO as well

        return new JsonResponse(['index' => []]);
    }
}
