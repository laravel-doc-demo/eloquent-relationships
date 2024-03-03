<?php

namespace Database\Factories;

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
            'uuid' => fake()->uuid,
            'title' => fake()->sentence,
            'content' => fake()->paragraph(10),
        ];
    }

    public function assignUser($userId)
    {
        return $this->state(fn (array $attributes) => [
            'user_id' => $userId,
            'author' => $userId,
        ]);
    }
}
