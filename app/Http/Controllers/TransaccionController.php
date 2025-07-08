<?php

namespace App\Http\Controllers;

use App\Models\Transaccion;
use App\Models\Finca;
use App\Models\Moneda;
use App\Models\TransaccionHistorica;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreTransaccionRequest;
use App\Http\Requests\UpdateTransaccionRequest;

class TransaccionController extends Controller
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

        return view('transacciones.index', compact(
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
    public function create()
    {
        // Obtener fincas y monedas para los selects
        $fincas = Finca::orderBy('nombre')->get();
        $monedas = Moneda::orderBy('codigo')->get();
        
        // Categorías predefinidas (puedes personalizar)
        $categorias = [
            'Venta de animales y Leche',
            'Compra de insumos',
            'Pago de mano de obra',
            'Mantenimiento',
            'Otros'
        ];
        
        return view('transacciones.create', compact('fincas', 'monedas', 'categorias'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTransaccionRequest $request)
    {
        // Crear transacción sin validaciones (SOLO PARA PRUEBAS)
        $transaccion = Transaccion::create([
            'finca_id' => $request->finca_id,
            'moneda_id' => $request->moneda_id,
            'tipo' => $request->tipo,
            'monto' => $request->monto,
            'fecha' => $request->fecha,
            'descripcion' => $request->descripcion,
            'categoria' => $request->categoria,
            'referencia' => $request->referencia
        ]);

        // Redireccionar con mensaje de éxito
        return redirect()->route('transacciones.index')
                         ->with('success', 'Transacción creada exitosamente! (Modo pruebas)');
    }

    /**
     * Display the specified resource.
     */
    public function show(Transaccion $transaccion)
    {
        // Cargar relaciones necesarias
    $transaccion->load(['finca', 'moneda']);
    
    return view('transacciones.show', compact('transaccion'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Transaccion $transaccion)
    {
    $fincas = Finca::orderBy('nombre')->get();
    $monedas = Moneda::orderBy('codigo')->get();
    
    $categorias = [
        'Venta de animales y Leche',
        'Compra de insumos',
        'Pago de mano de obra',
        'Mantenimiento',
        'Nomina'
    ];
    
    return view('transacciones.edit', compact(
        'transaccion',
        'fincas',
        'monedas',
        'categorias'
    ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTransaccionRequest $request, Transaccion $transaccion)
    {
        $transaccion->update($request->all());

        return redirect()->route('transacciones.index',$transaccion->id)
                        ->with('success', 'Transacciones actualizada exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Transaccion $transaccion)
    {
    //     $transaccion->delete();
    
    // return redirect()->route('transacciones.index')
    //                  ->with('success', 'Transacción eliminada exitosamente!');

    DB::transaction(function () use ($request, $transaccion) {
        // Crear registro histórico
        TransaccionHistorica::create([
            'transaccions_id' => $transaccion->id,
            'finca_id' => $transaccion->finca_id,
            'moneda_id' => $transaccion->moneda_id,
            'tipo' => $transaccion->tipo,
            'monto' => $transaccion->monto,
            'fecha' => $transaccion->fecha,
            'descripcion' => $transaccion->descripcion,
            'categoria' => $transaccion->categoria,
            'referencia' => $transaccion->referencia,
            'deleted_by' => auth()->id(),
            'delete_reason' => $request->input('delete_reason', 'Eliminación estándar')
        ]);

        // Eliminación suave
        $transaccion->delete();
    });

    return redirect()->route('transacciones.index')
        ->with('success', 'Transacción movida al histórico correctamente');
    }

    // app/Http/Controllers/ReporteController.php o en TransaccionController

public function reportes(Request $request)
{
    
}

public function generarPdf(Request $request)
{
    // Lógica similar pero para PDF
    $data = [/* datos para el PDF */];
    $pdf = PDF::loadView('transacciones.pdf', $data);
    return $pdf->download('reporte-transacciones.pdf');
}
}
