<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PropertyFeature;

class PropertyFeatureSeeder extends Seeder
{
    public function run(): void
    {
        PropertyFeature::factory()->create(['name' => 'Cochera', 'code' => 'cochera']);
        PropertyFeature::factory()->create(['name' => 'Piscina', 'code' => 'piscina']);
        PropertyFeature::factory()->create(['name' => 'Balcón', 'code' => 'balcon']);
        PropertyFeature::factory()->create(['name' => 'Patio', 'code' => 'patio']);
        PropertyFeature::factory()->create(['name' => 'Parrilla', 'code' => 'parrilla']);
    }
}
