<!-- resources/views/transacciones/historico.blade.php -->
@extends('layouts.layout')

@section('content')
<div class="container-fluid">

    <div class="card shadow">
        <div class="card-header bg-secondary text-white">
            <h3><i class="fas fa-history"></i> Histórico de Transacciones Eliminadas</h3>
        </div>
        <button type="button" onclick="window.print()" class="btn btn-success">
                            <i class="fas fa-print"></i> Imprimir
        </button>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>Fecha Trans.</th>
                            <th>Fecha Elim.</th>
                            <th>Tipo</th>
                            <th>Monto</th>
                            <th>Descripción</th>
                            <th>Eliminado por</th>
                            <th>Motivo</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($transacciones as $transaccion)
                        <tr>
                            <td>{{ $transaccion->fecha }}</td>
                            <td>{{ $transaccion->fecha }}</td>
                            <td>
                                <span class="badge bg-{{ $transaccion->tipo == 'ingreso' ? 'success' : 'danger' }}">
                                    {{ ucfirst($transaccion->tipo) }}
                                </span>
                            </td>
                            <td class="text-end">{{ number_format($transaccion->monto, 2) }}</td>
                            <td>{{ $transaccion->descripcion }}</td>
                            <td>{{ $transaccion->deletedBy->name ?? 'Sistema' }}</td>
                            <td>{{ $transaccion->delete_reason ?? 'No especificado' }}</td>
                            <td>
                                <button class="btn btn-sm btn-info" data-bs-toggle="modal" 
                                    data-bs-target="#detalleModal{{ $transaccion->id }}">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center">No hay registros en el histórico</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            {{ $transacciones->links() }}
        </div>
    </div>
</div>

<!-- Modal para detalles -->
@foreach($transacciones as $transaccion)
<div class="modal fade" id="detalleModal{{ $transaccion->id }}" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Detalle de Transacción Histórica</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Fecha Transacción:</strong> {{ $transaccion->fecha}}</p>
                        <p><strong>Fecha Eliminación:</strong> {{ $transaccion->fecha }}</p>
                        <p><strong>Tipo:</strong> {{ ucfirst($transaccion->tipo) }}</p>
                        <p><strong>Monto:</strong> {{ number_format($transaccion->monto, 2) }}</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Finca:</strong> {{ $transaccion->finca->nombre }}</p>
                        <p><strong>Moneda:</strong> {{ $transaccion->moneda->codigo }}</p>
                        <p><strong>Categoría:</strong> {{ $transaccion->categoria }}</p>
                        <p><strong>Referencia:</strong> {{ $transaccion->referencia ?? 'N/A' }}</p>
                    </div>
                </div>
                <div class="mt-3">
                    <h5>Descripción:</h5>
                    <p>{{ $transaccion->descripcion }}</p>
                </div>
                <div class="mt-3">
                    <h5>Información de Eliminación:</h5>
                    <p><strong>Eliminado por:</strong> {{ $transaccion->deletedBy->name ?? 'Sistema' }}</p>
                    <p><strong>Motivo:</strong> {{ $transaccion->delete_reason ?? 'No especificado' }}</p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
@endforeach
@endsection