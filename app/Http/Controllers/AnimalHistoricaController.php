<?php

namespace App\Http\Controllers;

use App\Models\Animal;
use App\Models\AnimalHistorica;
use Illuminate\Http\Request;
class AnimalHistoricaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
          $query = Animal::onlyTrashed()
        ->with(['lote.finca', 'historial' => function($q) {
            $q->where('deleted_reason', 'eliminado')->latest()->with('usuario');
        }])
        ->latest('deleted_at');

    // Filtros
    if ($request->filled('search')) {
        $query->where(function($q) use ($request) {
            $q->where('codigo', 'like', "%{$request->search}%")
              ->orWhere('raza', 'like', "%{$request->search}%")
              ->orWhere('observaciones', 'like', "%{$request->search}%")
              ->orWhereHas('lote', function($q) use ($request) {
                  $q->where('nombre', 'like', "%{$request->search}%");
              });
        });
    }

    $animales = $query->paginate(25);

    return view('animales.historico', compact('animales'));
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
