<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id' => $this->faker->uuid(),
            'user_id' => User::factory(),
            'entry_title' => $this->faker->sentence(8),
            'entry_content' => $this->faker->paragraph(50),
            'like_count' => $this->faker->numberBetween(0,100),
            'created_at' => $this->faker->dateTimeBetween('-25 days', 'now')
        ];
    }
}
