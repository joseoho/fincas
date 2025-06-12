<?php

namespace App\Http\Controllers;

use App\Models\Lote;
use App\Models\Finca;
use Illuminate\Http\Request;
use App\Http\Requests\StoreLoteRequest;
use App\Http\Requests\UpdateLoteRequest;

class LoteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
       $query = Lote::with(['finca', 'animales'])
                ->withCount(['animales', 'movimientosOrigen', 'movimientosDestino']);

    // Búsqueda
    if ($request->has('search')) {
        $search = $request->search;
        $query->where(function($q) use ($search) {
            $q->where('nombre', 'like', "%{$search}%")
              ->orWhere('proposito', 'like', "%{$search}%")
              ->orWhere('descripcion', 'like', "%{$search}%")
              ->orWhereHas('finca', function($q) use ($search) {
                  $q->where('nombre', 'like', "%{$search}%");
              });
        });
    }

    // Filtro por finca
    if ($request->has('finca_id')) {
        $query->where('finca_id', $request->finca_id);
    }

    $lotes = $query->paginate(10);
    $fincas = Finca::all(); // Para el select de filtro

    return view('lotes.index', compact('lotes', 'fincas'));
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
            $fincas = Finca::all();
            return view('lotes.create', compact('fincas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreLoteRequest $request)
    {
        $lote = new Lote();
        $lote->finca_id = $request->input('finca_id');
        $lote->nombre = $request->input('nombre');
        $lote->proposito = $request->input('proposito');
        $lote->capacidad_maxima = $request->input('capacidad_maxima');
        $lote->descripcion = $request->input('descripcion');
        $lote->save();
        // return redirect()
        return back()->with('notification', 'Registrado');
    }

    /**
     * Display the specified resource.
     */
    public function show(Lote $lote)
    {
        $lote->load([
        'finca',
        'animales',
        'movimientosOrigen.animal',
        'movimientosOrigen.loteOrigen',
        'movimientosOrigen.loteDestino',
        'movimientosDestino.animal',
        'movimientosDestino.loteOrigen',
        'movimientosDestino.loteDestino'
    ]);

    return view('lotes.show', compact('lote'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Lote $lote)
    {
        $lote->load('finca'); // Carga la relación finca si no viene cargada
        $fincas = Finca::all();
    
        return view('lotes.edit', compact('lote','fincas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateLoteRequest $request, Lote $lote)
    {
        try {
        // Actualizar el lote directamente con todos los datos recibidos
        $lote->update($request->all());
        
        return redirect()->route('lotes.index', $lote->id)
                        ->with('success', 'Lote actualizado exitosamente (modo prueba)');
                        
    } catch (\Exception $e) {
        return back()->withInput()
                     ->with('error', 'Error al actualizar el lote: '.$e->getMessage());
    }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Lote $lote)
    {
         if ($lote->animales()->count() > 0) {
            return back()->with('error', 'No se puede eliminar el lote porque tiene animales asignados.');
        }

        $lote->delete();
        return redirect()->route('lotes.index')->with('success', 'Lote eliminado exitosamente.');
    }
    
}
