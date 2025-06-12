<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


class LotesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         $now = Carbon::now();

        $lotes = [
            [
                'finca_id' => '1',
                'nombre' => 'cabeza cebu',
                'proposito' => 'engorde',
                'capacidad_maxima' => 56,
                'descripcion' => 'Mautes de 350kg promedio',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'finca_id' => '2',
                'nombre' => 'cola cebu',
                'proposito' => 'engorde',
                'capacidad_maxima' => 45,
                'descripcion' => 'Mautes de 200kg promedio',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'finca_id' => '3',
                'nombre' => 'cabeza f1',
                'proposito' => 'leche',
                'capacidad_maxima' => 30,
                'descripcion' => 'novilas de 15litros promedio',
                'created_at' => $now,
                'updated_at' => $now
            ],
           
        ];

        DB::table('lotes')->insert($lotes);
    }
}
