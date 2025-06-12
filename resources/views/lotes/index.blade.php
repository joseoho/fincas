@extends('layouts.layout')

@section('title', 'Gestión de Lotes')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-6">
            <h1 class="h3 mb-0 text-gray-800">
                <i class="fas fa-map-marked-alt"></i> Gestión de Lotes
            </h1>
        </div>
        <div class="col-md-6 text-end">
            <a href="{{ route('lotes.create') }}" class="btn btn-primary">
                <i class="fas fa-plus-circle"></i> Nuevo Lote
            </a>
        </div>
    </div>

    <!-- Filtros de búsqueda -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ route('lotes.index') }}" method="GET" class="form-inline">
                <div class="row g-3 align-items-center">
                    <div class="col-md-4">
                        <input type="text" name="search" class="form-control" placeholder="Buscar por nombre, propósito o finca..." 
                               value="{{ request('search') }}">
                    </div>
                    <div class="col-md-3">
                        <select name="finca_id" class="form-control">
                            <option value="">Todas las fincas</option>
                            @foreach($fincas as $finca)
                                <option value="{{ $finca->id }}" {{ request('finca_id') == $finca->id ? 'selected' : '' }}>
                                    {{ $finca->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search"></i> Buscar
                        </button>
                        @if(request()->has('search') || request()->has('finca_id'))
                            <a href="{{ route('lotes.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times"></i> Limpiar
                            </a>
                        @endif
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Tabla de lotes -->
    <div class="card shadow">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <th>Nombre</th>
                            <th>Finca</th>
                            <th>Propósito</th>
                            <th>Capacidad</th>
                            <th>Animales</th>
                            <th>Movimientos</th>
                            <th class="actions-column">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($lotes as $lote)
                            <tr>
                                <td>
                                    <a href="{{ route('lotes.show', $lote->id) }}" class="text-primary">
                                        <strong>{{ $lote->nombre }}</strong>
                                    </a>
                                    @if($lote->descripcion)
                                        <small class="d-block text-muted">{{ Str::limit($lote->descripcion, 50) }}</small>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('fincas.show', $lote->finca_id) }}" class="text-info">
                                        {{ $lote->finca->nombre }}
                                    </a>
                                </td>
                                <td>{{ $lote->proposito }}</td>
                                <td class="text-center">
                                    <span class="badge {{ $lote->animales_count >= $lote->capacidad_maxima ? 'bg-danger' : 'bg-primary' }}">
                                        {{ $lote->animales_count }} / {{ $lote->capacidad_maxima }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-success">{{ $lote->animales_count }}</span>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-info" title="Movimientos de entrada">
                                        <i class="fas fa-sign-in-alt"></i> {{ $lote->movimientos_destino_count }}
                                    </span>
                                    <span class="badge bg-warning text-dark" title="Movimientos de salida">
                                        <i class="fas fa-sign-out-alt"></i> {{ $lote->movimientos_origen_count }}
                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('lotes.show', $lote->id) }}" class="btn btn-sm btn-info" 
                                           title="Ver detalles">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('lotes.edit', $lote->id) }}" class="btn btn-sm btn-warning" 
                                           title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('lotes.destroy', $lote->id) }}" method="POST" 
                                              class="d-inline delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" title="Eliminar"
                                                    {{ $lote->animales_count > 0 ? 'disabled' : '' }}>
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                            @if($lote->animales_count > 0)
                                                <small class="d-block text-muted">No se puede eliminar</small>
                                            @endif
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">No se encontraron lotes registrados</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Paginación -->
            @if($lotes->hasPages())
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <div class="text-muted">
                        Mostrando {{ $lotes->firstItem() }} a {{ $lotes->lastItem() }} de {{ $lotes->total() }} registros
                    </div>
                    <div>
                        {{ $lotes->onEachSide(1)->links() }}
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Confirmación para eliminar
    document.querySelectorAll('.delete-form').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            Swal.fire({
                title: '¿Estás seguro?',
                text: "¡No podrás revertir esto!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, eliminarlo!'
            }).then((result) => {
                if (result.isConfirmed) {
                    this.submit();
                }
            });
        });
    });

    document.addEventListener('DOMContentLoaded', function() {
        // Limpiar búsqueda
        document.querySelector('.btn-clear-search')?.addEventListener('click', function() {
            document.querySelector('input[name="search"]').value = '';
            document.querySelector('select[name="finca_id"]').value = '';
        });
        
        // Opcional: Búsqueda con delay
        let searchTimer;
        document.querySelector('input[name="search"]')?.addEventListener('input', function() {
            clearTimeout(searchTimer);
            searchTimer = setTimeout(() => {
                this.form.submit();
            }, 500);
        });
    });
</script>
@endpush

@push('styles')
<style>
    .badge {
        font-size: 0.9em;
        min-width: 30px;
    }
    .table th {
        white-space: nowrap;
    }
    .actions-column {
        width: 180px;
    }
    .bg-danger {
        background-color: #dc3545 !important;
    }
    .bg-primary {
        background-color: #0d6efd !important;
    }
    .bg-success {
        background-color: #198754 !important;
    }
    .bg-info {
        background-color: #0dcaf0 !important;
    }
    .bg-warning {
        background-color: #ffc107 !important;
    }
</style>
@endpush