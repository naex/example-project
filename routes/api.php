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

Route::name('api.events.')
    ->middleware('auth:sanctum')
    ->group(function () {
        Route::get('events', [EventsController::class, 'index'])
            ->name('index');
    });
