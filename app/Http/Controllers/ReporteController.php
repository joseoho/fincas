<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaccion;
use App\Models\Finca;
use App\Models\Moneda;

use Illuminate\Support\Facades\DB;

class ReporteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
 //
        // Obtener parámetros de búsqueda
        $search = $request->input('search');
        $tipo = $request->input('tipo');
        $finca_id = $request->input('finca_id');
        $fecha_inicio = $request->input('fecha_inicio');
        $fecha_fin = $request->input('fecha_fin');
        
        // Construir consulta
        $query = Transaccion::with(['finca', 'moneda'])
            ->orderBy('fecha', 'desc')
            ->orderBy('created_at', 'desc');

        // Aplicar filtros
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('descripcion', 'like', "%$search%")
                  ->orWhere('referencia', 'like', "%$search%")
                  ->orWhere('categoria', 'like', "%$search%");
            });
        }

        if ($tipo) {
            $query->where('tipo', $tipo);
        }

        if ($finca_id) {
            $query->where('finca_id', $finca_id);
        }

        if ($fecha_inicio && $fecha_fin) {
            $query->whereBetween('fecha', [$fecha_inicio, $fecha_fin]);
        }

        // Obtener datos para filtros
        $fincas = Finca::orderBy('nombre')->get();
        $monedas = Moneda::all();
        
        // Paginar resultados
        $transacciones = $query->paginate(25);

        // Totales
        $totales = [
            'ingresos' => Transaccion::where('tipo', 'ingreso')->sum('monto'),
            'egresos' => Transaccion::where('tipo', 'egreso')->sum('monto'),
            'saldo' => Transaccion::where('tipo', 'ingreso')->sum('monto') - 
                      Transaccion::where('tipo', 'egreso')->sum('monto')
        ];

        // Totales filtrados
        if ($request->anyFilled(['search', 'tipo', 'finca_id', 'fecha_inicio', 'fecha_fin'])) {
            $totalesFiltrados = [
                'ingresos' => (clone $query)->where('tipo', 'ingreso')->sum('monto'),
                'egresos' => (clone $query)->where('tipo', 'egreso')->sum('monto')
            ];
            $totalesFiltrados['saldo'] = $totalesFiltrados['ingresos'] - $totalesFiltrados['egresos'];
        } else {
            $totalesFiltrados = $totales;
        }

        return view('reportes.indextransacciones', compact(
            'transacciones',
            'fincas',
            'monedas',
            'search',
            'tipo',
            'finca_id',
            'fecha_inicio',
            'fecha_fin',
            'totales',
            'totalesFiltrados'
        ));

    }

    /**
     * Show the form for creating a new resource.
     */
   

    public function generarPdf(Request $request)
{
    // Aplicar los mismos filtros que en el método index
    $query = Transaccion::with(['finca', 'moneda'])
        ->orderBy('fecha', 'desc');
    
    if ($request->filled('search')) {
        // ... aplicar filtros ...
    }
    
    $transacciones = $query->get();
    $totales = [
        'ingresos' => $query->clone()->where('tipo', 'ingreso')->sum('monto'),
        'egresos' => $query->clone()->where('tipo', 'egreso')->sum('monto'),
        'saldo' => $query->clone()->where('tipo', 'ingreso')->sum('monto') - 
                  $query->clone()->where('tipo', 'egreso')->sum('monto')
    ];
    
    $pdf = \PDF::loadView('reportes.pdf', [
        'transacciones' => $transacciones,
        'totales' => $totales,
        'filtros' => $request->all()
    ]);
    
    return $pdf->download('reporte-transacciones-'.now()->format('YmdHis').'.pdf');
}
}
