<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\OperationType;

class OperationTypeSeeder extends Seeder
{
    public function run(): void
    {
        OperationType::factory()->create(['name' => 'Venta', 'code' => 'venta']);
        OperationType::factory()->create(['name' => 'Alquiler', 'code' => 'alquiler']);
    }
}
