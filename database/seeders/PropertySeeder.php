<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Property;
use App\Models\PropertyType;
use App\Models\PropertyStatus;
use App\Models\OperationType;

class PropertySeeder extends Seeder
{
    public function run(): void
    {
        $casa = PropertyType::where('code', 'casa')->first();
        $departamento = PropertyType::where('code', 'departamento')->first();
        $enVenta = PropertyStatus::where('code', 'en_venta')->first();
        $enAlquiler = PropertyStatus::where('code', 'en_alquiler')->first();
        $ventaType = OperationType::where('code', 'venta')->first();
        $alquilerType = OperationType::where('code', 'alquiler')->first();

        Property::factory()->create([
            'title' => 'Casa en venta - Barrio Norte',
            'description' => 'Amplia casa de 3 dormitorios con jardín y cochera.',
            'property_type_id' => $casa?->id,
        ])->operations()->create([
            'operation_type_id' => $ventaType?->id,
            'price' => 150000,
            'currency' => 'USD',
            'status' => $enVenta?->code ?? 'en_venta',
        ]);

        Property::factory()->create([
            'title' => 'Departamento en alquiler - Centro',
            'description' => 'Departamento luminoso de 2 ambientes con balcón.',
            'property_type_id' => $departamento?->id,
        ])->operations()->create([
            'operation_type_id' => $alquilerType?->id,
            'price' => 1200,
            'currency' => 'USD',
            'status' => $enAlquiler?->code ?? 'en_alquiler',
        ]);

        Property::factory()->create([
            'title' => 'PH a estrenar - Palermo',
            'description' => 'PH moderno con amenities y terraza.',
            'property_type_id' => $casa?->id,
        ])->operations()->create([
            'operation_type_id' => $ventaType?->id,
            'price' => 220000,
            'currency' => 'USD',
            'status' => $enVenta?->code ?? 'en_venta',
        ]);
    }
}
