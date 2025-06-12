<?php

namespace App\Http\Controllers;

use App\Models\Animal;
use App\Http\Requests\StoreAnimalRequest;
use App\Http\Requests\UpdateAnimalRequest;

use App\Models\Lote;
use Illuminate\Http\Request;
class AnimalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
                // Obtener parámetros de búsqueda
        $search = $request->input('search');
        $lote_id = $request->input('lote_id');
        $raza = $request->input('raza');
        $sexo = $request->input('sexo');
        $estado = $request->input('estado');

        // Construir la consulta
        $query = Animal::with('lote')
            ->when($search, function ($query, $search) {
                return $query->where('codigo', 'like', "%{$search}%")
                    ->orWhere('raza', 'like', "%{$search}%")
                    ->orWhere('observaciones', 'like', "%{$search}%");
            })
            ->when($lote_id, function ($query, $lote_id) {
                return $query->where('lote_id', $lote_id);
            })
            ->when($raza, function ($query, $raza) {
                return $query->where('raza', $raza);
            })
            ->when($sexo, function ($query, $sexo) {
                return $query->where('sexo', $sexo);
            })
            ->when($estado, function ($query, $estado) {
                return $query->where('estado', $estado);
            })
            ->orderBy('codigo');

        // Obtener todos los lotes para el filtro
        $lotes = Lote::orderBy('nombre')->get();
        
        // Razas disponibles para filtro
        $razas = Animal::select('raza')->distinct()->orderBy('raza')->pluck('raza');
        
        // Paginar resultados
        $animales = $query->paginate(15);

        return view('animales.index', compact('animales', 'lotes', 'razas', 'search', 'lote_id', 'raza', 'sexo', 'estado'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
         $lotes = Lote::orderBy('nombre')->get();
        return view('animales.create', compact('lotes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAnimalRequest $request)
    {
        $animal = new Animal();
        $animal->lote_id = $request->input('lote_id');
        $animal->codigo = $request->input('codigo');
        $animal->raza = $request->input('raza');
        $animal->sexo = $request->input('sexo');
        $animal->fecha_nacimiento = $request->input('fecha_nacimiento');
        $animal->peso_inicial = $request->input('peso_inicial');
        $animal->estado = $request->input('estado');
        $animal->observaciones = $request->input('observaciones');
       
        $animal->save();
        // return redirect()
        return back()->with('notification', 'Registrado');
    }

    /**
     * Display the specified resource.
     */
    public function show(Animal $animal)
    {
       return view('animales.show', compact('animal'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Animal $animal)
    {
        $lotes = Lote::orderBy('nombre')->get();
        return view('animales.edit', compact('animal', 'lotes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAnimalRequest $request, Animal $animal)
    {
         $animal->update($request->all());

        return redirect()->route('animales.index', $animal->id)
                        ->with('success', 'Animal actualizada exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Animal $animal)
    {
        $animal->delete();
        return redirect()->route('animales.index')->with('success', 'Animal eliminado exitosamente.');
    }
}
