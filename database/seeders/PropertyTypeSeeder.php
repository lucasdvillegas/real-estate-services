<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PropertyType;

class PropertyTypeSeeder extends Seeder
{
    public function run(): void
    {
        PropertyType::factory()->create(['name' => 'Casa', 'code' => 'casa']);
        PropertyType::factory()->create(['name' => 'Departamento', 'code' => 'departamento']);
        PropertyType::factory()->create(['name' => 'PH', 'code' => 'ph']);
        PropertyType::factory()->create(['name' => 'Terreno', 'code' => 'terreno']);
        PropertyType::factory()->create(['name' => 'Local', 'code' => 'local']);
        PropertyType::factory()->create(['name' => 'Oficina', 'code' => 'oficina']);
    }
}
