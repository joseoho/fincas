
@extends('layouts.layout')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-2 text-gray-800">Registrar Movimiento</h1>
    
    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ route('movimientos.store') }}" method="POST">
                @csrf
                
                <div class="form-group">
                    <label for="animal_id">Animal *</label>
                    <select name="animal_id" id="animal_id" class="form-control" required>
                        <option value="">Seleccione un animal</option>
                        @foreach($animales as $animal)
                        <option value="{{ $animal->id }}">
                            {{ $animal->codigo }} - {{ $animal->raza }} (Lote: {{ $animal->lote->nombre }})
                        </option>
                        @endforeach
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="lote_nuevo_id">Nuevo Lote *</label>
                    <select name="lote_nuevo_id" id="lote_nuevo_id" class="form-control" required>
                        <option value="">Seleccione un lote</option>
                        @foreach($lotes as $lote)
                        <option value="{{ $lote->id }}">{{ $lote->nombre }} (Finca: {{ $lote->finca->nombre }})</option>
                        @endforeach
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="fecha">Fecha *</label>
                    <input type="date" name="fecha" id="fecha" class="form-control" required 
                           value="{{ old('fecha', now()->format('Y-m-d')) }}">
                </div>
                
                <div class="form-group">
                    <label for="motivo">Motivo *</label>
                    <textarea name="motivo" id="motivo" class="form-control" required></textarea>
                </div>
                
                <button type="submit" class="btn btn-primary">Guardar Movimiento</button>
            </form>
        </div>
    </div>
</div>
@endsection