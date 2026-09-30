<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Currency;

class CurrencySeeder extends Seeder
{
    public function run(): void
    {
        Currency::create(['code' => 'ARS', 'name' => 'Peso argentino']);
        Currency::create(['code' => 'USD', 'name' => 'Dólar estadounidense']);
        Currency::create(['code' => 'EUR', 'name' => 'Euro']);
    }
}