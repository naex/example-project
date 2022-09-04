<?php

declare(strict_types=1);

use App\Http\Controllers\EventsController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->group(function () {
    Route::name('api.events.')->prefix('events')->group(function () {
        Route::get('', [EventsController::class, 'index'])
            ->name('index');

        Route::post('', [EventsController::class, 'store'])
            ->name('store');

        Route::delete('{eventId}', [EventsController::class, 'delete'])
            ->name('delete');
    });
});
