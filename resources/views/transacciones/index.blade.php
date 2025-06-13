@extends('layouts.layout')

@section('title', 'Gestión de Transacciones')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-6">
            <h1 class="h3 mb-0 text-gray-800">
                <i class="fas fa-exchange-alt"></i> Transacciones Financieras
            </h1>
        </div>
        <div class="col-md-6 text-end">
            <a href="{{ route('transacciones.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Nueva Transacción
            </a>
        </div>
    </div>

    <!-- Filtros -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Filtros</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('transacciones.index') }}" method="GET">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="search">Buscar</label>
                            <input type="text" class="form-control" id="search" name="search" 
                                   value="{{ request('search') }}" placeholder="Descripción, referencia...">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="tipo">Tipo</label>
                            <select class="form-control" id="tipo" name="tipo">
                                <option value="">Todos</option>
                                <option value="ingreso" {{ request('tipo') == 'ingreso' ? 'selected' : '' }}>Ingresos</option>
                                <option value="egreso" {{ request('tipo') == 'egreso' ? 'selected' : '' }}>Egresos</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="finca_id">Finca</label>
                            <select class="form-control" id="finca_id" name="finca_id">
                                <option value="">Todas</option>
                                @foreach($fincas as $finca)
                                    <option value="{{ $finca->id }}" {{ request('finca_id') == $finca->id ? 'selected' : '' }}>
                                        {{ $finca->nombre }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="fecha_inicio">Desde</label>
                            <input type="date" class="form-control" id="fecha_inicio" name="fecha_inicio" 
                                   value="{{ request('fecha_inicio') }}">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="fecha_fin">Hasta</label>
                            <input type="date" class="form-control" id="fecha_fin" name="fecha_fin" 
                                   value="{{ request('fecha_fin') }}">
                        </div>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-12 text-end">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-filter"></i> Filtrar
                        </button>
                        <a href="{{ route('transacciones.index') }}" class="btn btn-secondary">
                            <i class="fas fa-broom"></i> Limpiar
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Resumen -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Ingresos (Total)</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ number_format($totales['ingresos'], 2) }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-arrow-up fa-2x text-success"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                Egresos (Total)</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ number_format($totales['egresos'], 2) }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-arrow-down fa-2x text-danger"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Saldo</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ number_format($totales['saldo'], 2) }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-balance-scale fa-2x text-primary"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabla de transacciones -->
    <div class="card shadow">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="thead-light">
                        <tr>
                            <th>Fecha</th>
                            <th>Tipo</th>
                            <th>Finca</th>
                            <th>Descripción</th>
                            <th>Monto</th>
                            <th>Moneda</th>
                            <th>Categoría</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($transacciones as $transaccion)
                        <tr>
                            <td>{{ $transaccion->fecha }}</td>
                            <td>
                                @if($transaccion->tipo == 'ingreso')
                                    <span class="badge bg-success">Ingreso</span>
                                @else
                                    <span class="badge bg-danger">Egreso</span>
                                @endif
                            </td>
                            <td>{{ $transaccion->finca->nombre }}</td>
                            <td>{{ $transaccion->descripcion }}</td>
                            <td class="text-end">{{ number_format($transaccion->monto, 2) }}</td>
                            <td>{{ $transaccion->moneda->codigo }}</td>
                            <td>{{ $transaccion->categoria }}</td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('transacciones.show', $transaccion->id) }}" 
                                       class="btn btn-sm btn-info" title="Ver">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('transacciones.edit', $transaccion->id) }}" 
                                       class="btn btn-sm btn-warning" title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('transacciones.destroy', $transaccion->id) }}" 
                                          method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" 
                                                title="Eliminar" onclick="return confirm('¿Eliminar esta transacción?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center">No se encontraron transacciones</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Paginación -->
            <div class="mt-3">
                {{ $transacciones->appends(request()->query())->links() }}
            </div>

            <!-- Totales filtrados -->
            @if(request()->anyFilled(['search', 'tipo', 'finca_id', 'fecha_inicio', 'fecha_fin']))
            <div class="row mt-4">
                <div class="col-md-4">
                    <div class="alert alert-success">
                        <strong>Ingresos filtrados:</strong> 
                        {{ number_format($totalesFiltrados['ingresos'], 2) }}
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="alert alert-danger">
                        <strong>Egresos filtrados:</strong> 
                        {{ number_format($totalesFiltrados['egresos'], 2) }}
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="alert alert-primary">
                        <strong>Saldo filtrado:</strong> 
                        {{ number_format($totalesFiltrados['saldo'], 2) }}
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Inicializar datepickers
    $(document).ready(function() {
        $('#fecha_inicio, #fecha_fin').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true
        });
    });
</script>
@endpush