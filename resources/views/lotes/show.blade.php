@extends('layouts.layout')

@section('title', 'Detalles del Lote: ' . $lote->nombre)

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-6">
            <h1 class="h3 mb-0 text-gray-800">
                <i class="fas fa-map-marked-alt"></i> Detalles del Lote: {{ $lote->nombre }}
            </h1>
        </div>
        <div class="col-md-6 text-end">
            <a href="{{ route('lotes.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Volver al listado
            </a>
            <a href="{{ route('lotes.edit', $lote->id) }}" class="btn btn-warning">
                <i class="fas fa-edit"></i> Editar
            </a>
        </div>
    </div>

    <div class="row">
        <!-- Información principal -->
        <div class="col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3 bg-primary">
                    <h6 class="m-0 font-weight-bold text-white">
                        <i class="fas fa-info-circle"></i> Información Básica
                    </h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <th class="w-25 bg-light">Nombre</th>
                                    <td>{{ $lote->nombre }}</td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Finca</th>
                                    <td>
                                        <a href="{{ route('fincas.show', $lote->finca_id) }}" class="text-primary">
                                            {{ $lote->finca->nombre }}
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Propósito</th>
                                    <td>{{ $lote->proposito }}</td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Capacidad</th>
                                    <td>
                                        <span class="badge {{ $lote->animales->count() >= $lote->capacidad_maxima ? 'bg-danger' : 'bg-primary' }}">
                                            {{ $lote->animales->count() }} / {{ $lote->capacidad_maxima }} animales
                                        </span>
                                        @if($lote->animales->count() >= $lote->capacidad_maxima)
                                            <span class="text-danger small d-block mt-1">¡Capacidad máxima alcanzada!</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Descripción</th>
                                    <td>{{ $lote->descripcion ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Fecha creación</th>
                                    <td>{{ $lote->created_at->format('d/m/Y H:i') }}</td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Última actualización</th>
                                    <td>{{ $lote->updated_at->format('d/m/Y H:i') }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sección de Animales -->
        <div class="col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3 bg-success">
                    <h6 class="m-0 font-weight-bold text-white">
                        <i class="fas fa-cow"></i> Animales en este Lote ({{ $lote->animales->count() }})
                    </h6>
                </div>
                <div class="card-body">
                    @if($lote->animales->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-sm table-hover">
                                <thead>
                                    <tr>
                                        <th>Identificación</th>
                                        <th>Raza</th>
                                        <th>Estado</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($lote->animales as $animal)
                                    <tr>
                                        <td>{{ $animal->codigo }}</td>
                                        <td>{{ $animal->raza ?? 'N/A' }}</td>
                                        <td>
                                            <span class="badge bg-{{ $animal->estado == 'activo' ? 'success' : 'warning' }}">
                                                {{ ucfirst($animal->estado) }}
                                            </span>
                                        </td>
                                        <td>
                                            <a href="{{ route('animales.show', $animal->id) }}" class="btn btn-sm btn-info">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="alert alert-info mb-0">
                            No hay animales registrados en este lote.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Historial de Movimientos -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3 bg-info">
                    <h6 class="m-0 font-weight-bold text-white">
                        <i class="fas fa-exchange-alt"></i> Historial de Movimientos
                    </h6>
                </div>
                <div class="card-body">
                    @if($lote->movimientosOrigen->count() > 0 || $lote->movimientosDestino->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Fecha</th>
                                        <th>Tipo</th>
                                        <th>Animal</th>
                                        <th>Lote Origen</th>
                                        <th>Lote Destino</th>
                                        <th>Razón</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($lote->movimientosOrigen->sortByDesc('created_at') as $movimiento)
                                    <tr>
                                        <td>{{ $movimiento->created_at->format('d/m/Y H:i') }}</td>
                                        <td><span class="badge bg-danger">Salida</span></td>
                                        <td>{{ $movimiento->animal->identificacion }}</td>
                                        <td>{{ $movimiento->loteOrigen->nombre }}</td>
                                        <td>{{ $movimiento->loteDestino->nombre }}</td>
                                        <td>{{ $movimiento->razon }}</td>
                                    </tr>
                                    @endforeach
                                    @foreach($lote->movimientosDestino->sortByDesc('created_at') as $movimiento)
                                    <tr>
                                        <td>{{ $movimiento->created_at->format('d/m/Y H:i') }}</td>
                                        <td><span class="badge bg-success">Entrada</span></td>
                                        <td>{{ $movimiento->animal->identificacion }}</td>
                                        <td>{{ $movimiento->loteOrigen->nombre }}</td>
                                        <td>{{ $movimiento->loteDestino->nombre }}</td>
                                        <td>{{ $movimiento->razon }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="alert alert-info mb-0">
                            No hay registros de movimientos para este lote.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .card-header {
        border-radius: 0.35rem 0.35rem 0 0 !important;
    }
    .badge {
        font-size: 0.85em;
        padding: 0.35em 0.65em;
    }
    .bg-primary { background-color: #4e73df !important; }
    .bg-success { background-color: #1cc88a !important; }
    .bg-info { background-color: #36b9cc !important; }
    .bg-warning { background-color: #f6c23e !important; }
    .bg-danger { background-color: #e74a3b !important; }
    th.bg-light {
        background-color: #f8f9fc !important;
    }
</style>
@endpush