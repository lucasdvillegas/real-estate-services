<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\User;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        User::factory(10)->create();

        $this->call([
            PropertyTypeSeeder::class,
            PropertyFeatureSeeder::class,
            OperationTypeSeeder::class,
            CurrencySeeder::class,
            PropertyStatusSeeder::class,
            PropertySeeder::class,
            PropertyOperationSeeder::class,
        ]);
    }
}
