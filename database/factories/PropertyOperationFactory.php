<?php

namespace Database\Factories;

use App\Models\PropertyOperation;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<PropertyOperation>
 */
class PropertyOperationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'operation_type_id' => \App\Models\OperationType::inRandomOrder()->first()?->id ?? 1,
            'price' => fake()->randomFloat(2, 1000, 500000),
            'currency' => fake()->randomElement(['USD', 'ARS']),
            'status' => fake()->randomElement(['disponible', 'reservado', 'vendido']),
            'property_id' => \App\Models\Property::inRandomOrder()->first()?->id ?? 1,
        ];
    }
}

