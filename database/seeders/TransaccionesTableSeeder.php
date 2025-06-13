<?php

namespace Database\Seeders;

use App\Models\Transaccion;
use Illuminate\Database\Seeder;

class TransaccionesTableSeeder extends Seeder
{
    public function run()
    {
        // Tipos de transacción posibles
        $tipos = ['ingreso', 'egreso'];
        
        // Categorías de ejemplo
        $categorias = [
            'venta_cultivos', 
            'compra_insumos', 
            'pago_nomina', 
            'mantenimiento', 
            'servicios'
        ];

        // Crear 10 transacciones
        for ($i = 1; $i <= 10; $i++) {
            Transaccion::create([
                'finca_id' => rand(1, 3), // Asume que existen fincas con id 1-3
                'moneda_id' => rand(1, 2), // Asume que existen monedas con id 1-2
                'tipo' => $tipos[rand(0, 1)],
                'monto' => rand(100, 10000) / 10, // Montos entre 10.0 y 1000.0
                'fecha' => now()->subDays(rand(1, 30))->format('Y-m-d'), // Fechas aleatorias en los últimos 30 días
                'descripcion' => 'Transacción de ejemplo #' . $i,
                'categoria' => $categorias[rand(0, count($categorias) - 1)],
                'referencia' => 'REF-' . strtoupper(uniqid())
            ]);
        }

    
    }

    
}