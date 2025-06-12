<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class MonedaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('monedas')->insert([
            [
                'codigo' => 'BS',
                'tipo' => 'bolivar',
                'simbolo' => 'Bs.',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'codigo' => 'USD',
                'tipo' => 'dolar',
                'simbolo' => '$',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'codigo' => 'COP',
                'tipo' => 'pesos',
                'simbolo' => '$',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }
}
