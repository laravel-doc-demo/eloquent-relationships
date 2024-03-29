<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\RoleUser>
 */
class RoleUserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'active' => fake()->boolean,
            'created_by' => rand(1,5)
        ];
    }

    public function buildRelationship(int $id, string $column = 'user_id')
    {
        return $this->state(fn (array $attributes) => [
            $column => $id,
        ]);
    }
}
