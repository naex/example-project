<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;

class EventsController
{
    public function __construct()
    {

    }

    public function test(): JsonResponse
    {
        return new JsonResponse(['test' => []]);
    }
}
