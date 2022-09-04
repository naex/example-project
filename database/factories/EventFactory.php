<?php
declare(strict_types=1);

namespace Database\Factories;

use App\Models\Event;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Model;

/**
 * @extends Factory<Event>
 * @method Event create($attributes = [], ?Model $parent = null)
 */
class EventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->text(10),
            'description' => fake()->realText(),
            'valid_from' => Carbon::parse('2022-01-01 13:00:00'),
            'valid_to' => Carbon::parse('2022-01-02 14:00:00'),
        ];
    }
}
