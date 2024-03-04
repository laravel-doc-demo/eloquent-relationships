<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Deployment>
 */
class DeploymentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'commit_hash' => substr(fake()->sha256, 0 , 6),
        ];
    }



    public function assignEnvironmentId($id)
    {
        return $this->state(fn (array $attributes) => [
            'environment_id' => $id,
        ]);
    }
}
