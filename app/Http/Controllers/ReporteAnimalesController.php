<?php

namespace App\Http\Controllers;
use App\Models\Animal;
use App\Models\Lote;
use Illuminate\Http\Request;



class ReporteAnimalesController extends Controller
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

        return view('reportes.indexanimales', compact('animales', 'lotes', 'razas', 'search', 'lote_id', 'raza', 'sexo', 'estado'));
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
