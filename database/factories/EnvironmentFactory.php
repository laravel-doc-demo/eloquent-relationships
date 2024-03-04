<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Environment>
 */
class EnvironmentFactory extends Factory
{


    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            //
        ];
    }

    public function assignProjectId($id)
    {
        return $this->state(fn (array $attributes) => [
            'project_id' => $id,
        ]);
    }

    public function specificName(string $name) {
        return $this->state(fn (array $attributes) => [
            'name' => $name,
        ]);
    }

}
