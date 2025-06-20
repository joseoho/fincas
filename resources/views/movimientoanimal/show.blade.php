@extends('layouts.layout')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-2 text-gray-800">Detalles del Movimiento #{{ $movimiento->id }}</h1>
    
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <h5>Datos del Animal</h5>
                    <p><strong>Código:</strong> {{ $movimiento->animal->codigo }}</p>
                    <p><strong>Raza:</strong> {{ $movimiento->animal->raza }}</p>
                    <p><strong>Sexo:</strong> {{ ucfirst($movimiento->animal->sexo) }}</p>
                </div>
                <div class="col-md-6">
                    <h5>Información del Movimiento</h5>
                    <p><strong>Fecha:</strong> {{ $movimiento->fecha }}</p>
                    <p><strong>Lote Anterior:</strong> {{ $movimiento->loteAnterior->nombre ?? 'N/A' }}</p>
                    <p><strong>Lote Nuevo:</strong> {{ $movimiento->loteNuevo->nombre }}</p>
                    <p><strong>Motivo:</strong> {{ $movimiento->motivo }}</p>
                </div>
            </div>
            
            <a href="{{ route('movimientos.index') }}" class="btn btn-secondary mt-3">
                <i class="fas fa-arrow-left"></i> Volver
            </a>
        </div>
    </div>
</div>
@endsection