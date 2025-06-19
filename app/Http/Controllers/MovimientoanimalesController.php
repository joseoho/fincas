<?php

namespace App\Http\Controllers;

use App\Models\Movimientoanimal;
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
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMovimientoanimalRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Movimientoanimal $movimientoanimal)
    {
        //
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
