<!-- resources/views/transacciones/confirm-delete.blade.php -->
@extends('layouts.layout')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header bg-warning">
            <h3>Confirmar Eliminación</h3>
        </div>
        <div class="card-body">
            <p>Estás a punto de mover esta transacción al histórico:</p>
            
            <ul>
                <li><strong>Fecha:</strong> {{ $transaccion->fecha }}</li>
                <li><strong>Tipo:</strong> {{ ucfirst($transaccion->tipo) }}</li>
                <li><strong>Monto:</strong> {{ number_format($transaccion->monto, 2) }}</li>
                <li><strong>Descripción:</strong> {{ $transaccion->descripcion }}</li>
            </ul>

            <form action="{{ route('transacciones.destroy', $transaccion->id) }}" method="POST">
                @csrf
                @method('DELETE')
                
                <div class="form-group">
                    <label for="delete_reason">Motivo de eliminación (opcional):</label>
                    <textarea class="form-control" id="delete_reason" name="delete_reason" rows="3"></textarea>
                </div>
                
                <div class="mt-3">
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash"></i> Confirmar Eliminación
                    </button>
                    <a href="{{ route('transacciones.index') }}" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection