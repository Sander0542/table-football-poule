<?php

namespace Database\Factories;

use App\Models\Game;
use App\Models\GameUser;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<GameUser>
 */
class GameUserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'game_id' => Game::factory(),
            'user_id' => User::factory(),
            'winner' => $this->faker->boolean,
            'team' => $this->faker->randomElement(['blue', 'red']),
            'position' => $this->faker->randomElement(['offense', 'defense']),
        ];
    }
}
