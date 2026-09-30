<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PropertyStatus;

class PropertyStatusSeeder extends Seeder
{
    public function run(): void
    {
        PropertyStatus::factory()->create(['name' => 'Vendido', 'code' => 'vendido']);
        PropertyStatus::factory()->create(['name' => 'Alquilado', 'code' => 'alquilado']);
        PropertyStatus::factory()->create(['name' => 'En Alquiler', 'code' => 'en_alquiler']);
        PropertyStatus::factory()->create(['name' => 'En Venta', 'code' => 'en_venta']);
    }
}
