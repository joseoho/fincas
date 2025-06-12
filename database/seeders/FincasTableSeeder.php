<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class FincasTableSeeder extends Seeder
{
    public function run()
    {
        $now = Carbon::now();

        $fincas = [
            [
                'nombre' => 'La Esperanza',
                'ubicacion' => 'Municipio Libertador, Estado Mérida',
                'area' => 120.5,
                'descripcion' => 'Finca dedicada a la cría de ganado lechero',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'nombre' => 'El Porvenir',
                'ubicacion' => 'Municipio Campo Elías, Estado Mérida',
                'area' => 85.75,
                'descripcion' => 'Producción mixta (leche y carne)',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'nombre' => 'Santa Rosa',
                'ubicacion' => 'Municipio Rangel, Estado Mérida',
                'area' => 150.0,
                'descripcion' => 'Especializada en ganado Brahman',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'nombre' => 'San José',
                'ubicacion' => 'Municipio Sucre, Estado Mérida',
                'area' => 65.25,
                'descripcion' => 'Finca familiar con producción artesanal',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'nombre' => 'Las Acacias',
                'ubicacion' => 'Municipio Tovar, Estado Mérida',
                'area' => 200.0,
                'descripcion' => 'Finca modelo con tecnología de punta',
                'created_at' => $now,
                'updated_at' => $now
            ]
        ];

        DB::table('fincas')->insert($fincas);
    }
}