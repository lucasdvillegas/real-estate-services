<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PropertyOperation;
use App\Models\Property;
use App\Models\OperationType;

class PropertyOperationSeeder extends Seeder
{
    public function run(): void
    {
        $properties = Property::all();
        $operationType = OperationType::where('code', 'alquiler')->first();

        if ($properties->isNotEmpty() && $operationType) {
            PropertyOperation::factory()->create([
                'property_id' => $properties->first()->id,
                'operation_type_id' => $operationType->id,
                'price' => 1800,
                'currency' => 'USD',
                'status' => 'en_alquiler',
            ]);
        }
    }
}
