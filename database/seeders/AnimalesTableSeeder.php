<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AnimalesTableSeeder extends Seeder
{
    public function run()
    {
        $now = Carbon::now();
        $lote_id = 1; // Todos pertenecen al lote 1

        $animales = [
            [
                'lote_id' => $lote_id,
                'codigo' => 'BOV-001',
                'raza' => 'Brahman',
                'sexo' => 'macho',
                'fecha_nacimiento' => '2022-01-15',
                'peso_inicial' => 320.5,
                'estado' => 'activo',
                'observaciones' => 'Toro reproductor',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'lote_id' => $lote_id,
                'codigo' => 'BOV-002',
                'raza' => 'Holstein',
                'sexo' => 'hembra',
                'fecha_nacimiento' => '2021-08-23',
                'peso_inicial' => 280.0,
                'estado' => 'activo',
                'observaciones' => 'Producción lechera alta',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'lote_id' => $lote_id,
                'codigo' => 'BOV-003',
                'raza' => 'Angus',
                'sexo' => 'macho',
                'fecha_nacimiento' => '2023-03-10',
                'peso_inicial' => 180.75,
                'estado' => 'activo',
                'observaciones' => 'En crecimiento para engorde',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'lote_id' => $lote_id,
                'codigo' => 'BOV-004',
                'raza' => 'Simmental',
                'sexo' => 'hembra',
                'fecha_nacimiento' => '2020-11-05',
                'peso_inicial' => 350.0,
                'estado' => 'activo',
                'observaciones' => 'Madre de crías selectas',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'lote_id' => $lote_id,
                'codigo' => 'BOV-005',
                'raza' => 'Brahman',
                'sexo' => 'hembra',
                'fecha_nacimiento' => '2022-05-30',
                'peso_inicial' => 290.25,
                'estado' => 'enfermo',
                'observaciones' => 'En tratamiento veterinario',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'lote_id' => $lote_id,
                'codigo' => 'BOV-006',
                'raza' => 'Holstein',
                'sexo' => 'hembra',
                'fecha_nacimiento' => '2021-12-12',
                'peso_inicial' => 310.0,
                'estado' => 'activo',
                'observaciones' => 'Producción 20L/día',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'lote_id' => $lote_id,
                'codigo' => 'BOV-007',
                'raza' => 'Angus',
                'sexo' => 'macho',
                'fecha_nacimiento' => '2023-01-20',
                'peso_inicial' => 200.5,
                'estado' => 'activo',
                'observaciones' => 'Destinado a venta',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'lote_id' => $lote_id,
                'codigo' => 'BOV-008',
                'raza' => 'Brahman',
                'sexo' => 'hembra',
                'fecha_nacimiento' => '2021-07-17',
                'peso_inicial' => 275.75,
                'estado' => 'vendido',
                'observaciones' => 'Vendido el 15/03/2023',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'lote_id' => $lote_id,
                'codigo' => 'BOV-009',
                'raza' => 'Simmental',
                'sexo' => 'macho',
                'fecha_nacimiento' => '2020-09-08',
                'peso_inicial' => 420.0,
                'estado' => 'activo',
                'observaciones' => 'Semental principal',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'lote_id' => $lote_id,
                'codigo' => 'BOV-010',
                'raza' => 'Holstein',
                'sexo' => 'hembra',
                'fecha_nacimiento' => '2023-02-14',
                'peso_inicial' => 165.25,
                'estado' => 'activo',
                'observaciones' => 'Ternera en desarrollo',
                'created_at' => $now,
                'updated_at' => $now
            ]
        ];

        DB::table('animals')->insert($animales);
    }
}