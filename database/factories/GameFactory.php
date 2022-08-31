<?php

namespace Database\Factories;

use App\Models\Game;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Game>
 */
class GameFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'score_blue' => $this->faker->numberBetween(0, 10),
            'score_red' => $this->faker->numberBetween(0, 10),
            'played_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
        ];
    }
}
