<?php

namespace Database\Factories;

use App\Models\PropertyStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<PropertyStatus>
 */
class PropertyStatusFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->word(),
            'code' => fake()->unique()->slug(),
        ];
    }
}
