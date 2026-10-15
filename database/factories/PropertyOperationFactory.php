<?php

namespace Database\Factories;

use App\Models\Property;
use App\Models\PropertyOperation;
use App\Models\OperationType;
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
            'property_id' => Property::factory(),
            'operation_type_id' => OperationType::factory(),
            'price' => fake()->randomFloat(2, 50000, 500000),
            'currency' => 'USD',
            'status' => 'en_venta',
        ];
    }
}

