<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Car>
 */
class CarFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'model' => fake()->word,
        ];
    }

    public function assignMechanic($mechanicId)
    {
        return $this->state(fn (array $attributes) => [
            'mechanic_id' => $mechanicId,
        ]);
    }
}
