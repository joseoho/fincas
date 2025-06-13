@extends('layouts.layout')

@section('content')
<div class="container py-4">
    <div class="card">
        <div class="card-header bg-primary text-white">
            <div class="d-flex justify-content-between align-items-center">
                <h2 class="h5 mb-0">Detalles de Transacción</h2>
                <div>
                    <a href="{{ route('transacciones.edit', $transaccion) }}" class="btn btn-sm btn-light">
                        <i class="fas fa-edit"></i> Editar
                    </a>
                    <form action="{{ route('transacciones.destroy', $transaccion) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar esta transacción?')">
                            <i class="fas fa-trash"></i> Eliminar
                        </button>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <h5 class="mb-3">Información Básica</h5>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">
                            <strong>Referencia:</strong> {{ $transaccion->referencia }}
                        </li>
                        <li class="list-group-item">
                            <strong>Tipo:</strong> 
                            <span class="badge bg-{{ $transaccion->tipo === 'ingreso' ? 'success' : 'danger' }}">
                                {{ ucfirst($transaccion->tipo) }}
                            </span>
                        </li>
                        <li class="list-group-item">
                            <strong>Monto:</strong> 
                            {{ number_format($transaccion->monto, 2) }} {{ $transaccion->moneda->codigo }}
                        </li>
                        <li class="list-group-item">
                            <strong>Fecha:</strong> {{ $transaccion->fecha }}
                        </li>
                    </ul>
                </div>
                
                <div class="col-md-6">
                    <h5 class="mb-3">Información Adicional</h5>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">
                            <strong>Finca:</strong> {{ $transaccion->finca->nombre }}
                        </li>
                        <li class="list-group-item">
                            <strong>Categoría:</strong> {{ $transaccion->categoria }}
                        </li>
                        <li class="list-group-item">
                            <strong>Descripción:</strong> {{ $transaccion->descripcion }}
                        </li>
                        <li class="list-group-item">
                            <strong>Registrado el:</strong> {{ $transaccion->created_at->format('d/m/Y H:i') }}
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        
        <div class="card-footer">
            <a href="{{ route('transacciones.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Volver al listado
            </a>
        </div>
    </div>
</div>
@endsection