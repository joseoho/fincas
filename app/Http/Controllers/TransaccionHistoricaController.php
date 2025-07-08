<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TransaccionHistorica;

class TransaccionHistoricaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = TransaccionHistorica::with(['transaccion', 'finca', 'moneda', 'deletedBy'])
        ->latest();
    
    // Filtros
    if ($request->filled('search')) {
        $query->where('descripcion', 'like', "%{$request->search}%")
              ->orWhere('referencia', 'like', "%{$request->search}%");
    }
    
    $transacciones = $query->paginate(25);
    
    return view('transacciones.historico', compact('transacciones'));
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
