@extends('layouts.layout')

@section('title', 'Gestión de Fincas')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-6">
            <h1 class="h3 mb-0 text-gray-800">
                <i class="fas fa-tractor"></i> Gestión de Fincas
            </h1>
        </div>
        <div class="col-md-6 text-end">
            <a href="{{ route('fincas.create') }}" class="btn btn-primary">
                <i class="fas fa-plus-circle"></i> Nueva Finca
            </a>
        </div>
    </div>

    <!-- Filtros de búsqueda -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ route('fincas.index') }}" method="GET" class="form-inline">
                <div class="row g-3 align-items-center">
                    <div class="col-md-4">
                        <input type="text" name="search" class="form-control" placeholder="Buscar por nombre o ubicación..." 
                               value="{{ request('search') }}">
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search"></i> Buscar
                        </button>
                        @if(request()->has('search'))
                            <a href="{{ route('fincas.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times"></i> Limpiar
                            </a>
                        @endif
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Tabla de fincas -->
    <div class="card shadow">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <th>Nombre</th>
                            <th>Ubicación</th>
                            <th>Área (ha)</th>
                            <th>Lotes</th>
                            <th>Animales</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($fincas as $finca)
                            <tr>
                                <td>
                                    <a href="{{ route('fincas.show', $finca->id) }}" class="text-primary">
                                        <strong>{{ $finca->nombre }}</strong>
                                    </a>
                                </td>
                                <td>{{ $finca->ubicacion ?? 'N/A' }}</td>
                                <td class="text-end">{{ $finca->area ? number_format($finca->area, 2) : 'N/A' }}</td>
                                <td class="text-center">
                                    <span class="badge bg-primary">{{ $finca->lotes_count }}</span>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-success">{{ $finca->animales_count }}</span>
                                </td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('fincas.show', $finca->id) }}" class="btn btn-sm btn-info" 
                                           title="Ver detalles">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('fincas.edit', $finca->id) }}" class="btn btn-sm btn-warning" 
                                           title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('fincas.destroy', $finca->id) }}" method="POST" 
                                              class="d-inline delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" title="Eliminar">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">No se encontraron fincas registradas</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Paginación -->
            @if($fincas->hasPages())
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <div class="text-muted">
                        Mostrando {{ $fincas->firstItem() }} a {{ $fincas->lastItem() }} de {{ $fincas->total() }} registros
                    </div>
                    <div>
                        {{ $fincas->links() }}
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
        width: 150px;
    }
</style>
@endpush