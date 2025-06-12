<?php

namespace App\Http\Controllers;

use App\Models\Finca;
use App\Models\Lote;
use App\Models\Animal;
use App\Models\Transaccion;
use Illuminate\Http\Request;
use App\Http\Requests\StoreFincaRequest;
use App\Http\Requests\UpdateFincaRequest;

class FincaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)

    {
            $search = $request->input('search');
            
            $query = Finca::query()
                ->withCount(['lotes', 'animales'])
                ->orderBy('nombre');
            
            if ($search) {
                $query->where(function($q) use ($search) {
                    $q->where('nombre', 'LIKE', "%{$search}%")
                    ->orWhere('ubicacion', 'LIKE', "%{$search}%");
                });
            }
            
            $fincas = $query->paginate(10);
            
            return view('fincas.index', compact('fincas', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // $pedidos = Pedido::get();
        // $camiones = Camion::get();
        // return view('fincas.create', compact('pedidos', 'camiones'));
        return view('fincas.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFincaRequest $request)
    {
        $finca = new Finca();
        $finca->nombre = $request->input('nombre');
        $finca->ubicacion = $request->input('ubicacion');
        $finca->area = $request->input('area');
        $finca->descripcion = $request->input('descripcion');
        $finca->save();
        // return redirect()
        return back()->with('notification', 'Registrado');
                // ->route('fincas.index', $finca->id)
                // ->with('success', 'finca registrado exitosamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(Finca $finca)
    {
         $finca->loadCount(['lotes', 'animales', 'transacciones']);
        
        // Obtener lotes agrupados por propósito
        $lotesPorProposito = $finca->lotes()
                                  ->selectRaw('proposito, count(*) as total')
                                  ->groupBy('proposito')
                                  ->get();
        
        // Obtener últimos movimientos de animales
        $ultimosMovimientos = $finca->animales()
                                   ->with(['movimientos' => function($query) {
                                       $query->latest()->take(5);
                                   }])
                                   ->whereHas('movimientos')
                                   ->get()
                                   ->pluck('movimientos')
                                   ->flatten()
                                   ->take(5);
        
        // Resumen financiero
        $resumenFinanciero = [
            'ingresos' => $finca->transacciones()
                                ->where('tipo', 'ingreso')
                                ->sum('monto'),
            'egresos' => $finca->transacciones()
                               ->where('tipo', 'egreso')
                               ->sum('monto'),
        ];

        return view('fincas.show', compact(
            'finca',
            'lotesPorProposito',
            'ultimosMovimientos',
            'resumenFinanciero'
        ));
    }

    /**
     * Show the form for editing the specified resource.
     */
   public function edit(Finca $finca)
    {
        return view('fincas.edit', compact('finca'));
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFincaRequest $request, Finca $finca)
    {
         $finca->update($request->all());

        return redirect()->route('fincas.show', $finca->id)
                        ->with('success', 'Finca actualizada exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Finca $finca)
    {
       // Verificar si hay lotes o transacciones asociadas
        if ($finca->lotes()->count() > 0 || $finca->transacciones()->count() > 0) {
            return redirect()->back()
                            ->with('error', 'No se puede eliminar la finca porque tiene lotes o transacciones asociadas.');
        }

        $finca->delete();

        return redirect()->route('fincas.index')
                        ->with('success', 'Finca eliminada exitosamente.');
    }
}
