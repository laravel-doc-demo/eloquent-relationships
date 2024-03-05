<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Image>
 */
class ImageFactory extends Factory
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

    public function url(string $modelName): static
    {
        return $this->state(fn (array $attributes) => [
            'url' => '/images/' . $modelName . '_image.jpg',
        ]);
    }

    public function setIdModel(int $id, string $className): static
    {
        return $this->state(fn (array $attributes) => [
            'imageable_id' => $id,
            'imageable_type' => "App\Models\\$className",
        ]);
    }
}
