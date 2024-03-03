<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comment>
 */
class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->sentence,
            'content' => fake()->paragraph(2),
        ];
    }

    public function addRelationship($id, $uuid): static
    {
        return $this->state(fn (array $attributes) => [
            'post_id' => $id,
            'article_id' => $id,
            'post_uuid' => $uuid,
        ]);
    }

    public function specificTitle(string $title) {
        return $this->state(fn (array $attributes) => [
            'title' => $title,
        ]);
    }
}
