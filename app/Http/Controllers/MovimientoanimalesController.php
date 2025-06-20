<?php

namespace App\Http\Controllers;

use App\Models\Movimientoanimal;
use App\Models\Animal;
use App\Models\Lote;
use Illuminate\Http\Request;
use App\Http\Requests\StoreMovimientoanimalRequest;
use App\Http\Requests\UpdateMovimientoanimalRequest;

class MovimientoanimalesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $movimientos = MovimientoAnimal::with(['animal', 'loteAnterior', 'loteNuevo'])
            ->latest()
            ->paginate(10);

        return view('movimientoanimal.index', compact('movimientos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
         $animales = Animal::where('estado', 'activo')->get();
        $lotes = Lote::all();
        
        return view('movimientoanimal.create', compact('animales', 'lotes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMovimientoanimalRequest $request)
    {
        // $movimiento = new Movimientoanimal();
        // $movimiento->animal_id = $request->input('animal_id');
        // // $movimiento->lote_anterior_id = $request->input('lote_anterior_id');
        // $movimiento->lote_nuevo_id = $request->input('lote_nuevo_id');
        // $movimiento->motivo = $request->input('motivo');
        // $movimiento->fecha = $request->input('fecha');
        // $movimiento->save();
        // // return redirect()
        // return back()->with('notification', 'Registrado');
         $animal = Animal::findOrFail($request->animal_id);
        
        $movimiento = MovimientoAnimal::create([
            'animal_id' => $request->animal_id,
            'lote_anterior_id' => $animal->lote_id, // Lote actual antes del movimiento
            'lote_nuevo_id' => $request->lote_nuevo_id,
            'motivo' => $request->motivo,
            'fecha' => $request->fecha
        ]);

        // Actualizar el lote del animal
        $animal->update(['lote_id' => $request->lote_nuevo_id]);

        return redirect()->route('movimientoanimal.index')
            ->with('success', 'Movimiento registrado correctamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(Movimientoanimal $movimiento)
    {
        return view('movimientoanimal.show', compact('movimiento'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Movimientoanimal $movimientoanimal)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMovimientoanimalRequest $request, Movimientoanimal $movimientoanimal)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Movimientoanimal $movimientoanimal)
    {
        //
    }
}
