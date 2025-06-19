@extends('layouts.layout')

@section('content')
<div class="container-fluid">
    <div class="row mb-3">
        <div class="col">
            <h1>Gestión de Animales</h1>
        </div>
        <div class="col text-end">
            <a href="{{ route('animales.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Nuevo Animal
            </a>
        </div>
    </div>

    <!-- Filtros -->
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-filter"></i> Filtros
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('animales.index') }}">
                <div class="row g-3">
                    <div class="col-md-3">
                        <label for="search" class="form-label">Buscar</label>
                        <input type="text" class="form-control" id="search" name="search" value="{{ $search }}" placeholder="Código, raza...">
                    </div>
                    <div class="col-md-2">
                        <label for="lote_id" class="form-label">Lote</label>
                        <select class="form-select" id="lote_id" name="lote_id">
                            <option value="">Todos</option>
                            @foreach($lotes as $lote)
                                <option value="{{ $lote->id }}" {{ $lote_id == $lote->id ? 'selected' : '' }}>{{ $lote->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label for="raza" class="form-label">Raza</label>
                        <select class="form-select" id="raza" name="raza">
                            <option value="">Todas</option>
                            @foreach($razas as $razaOption)
                                <option value="{{ $razaOption }}" {{ $raza == $razaOption ? 'selected' : '' }}>{{ $razaOption }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label for="sexo" class="form-label">Sexo</label>
                        <select class="form-select" id="sexo" name="sexo">
                            <option value="">Todos</option>
                            <option value="Macho" {{ $sexo == 'Macho' ? 'selected' : '' }}>Macho</option>
                            <option value="Hembra" {{ $sexo == 'Hembra' ? 'selected' : '' }}>Hembra</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label for="estado" class="form-label">Estado</label>
                        <select class="form-select" id="estado" name="estado">
                            <option value="">Todos</option>
                            <option value="Activo" {{ $estado == 'Activo' ? 'selected' : '' }}>Activo</option>
                            <option value="Vendido" {{ $estado == 'Vendido' ? 'selected' : '' }}>Vendido</option>
                            <option value="Enfermo" {{ $estado == 'Enfermo' ? 'selected' : '' }}>Enfermo</option>
                            <option value="Muerto" {{ $estado == 'Muerto' ? 'selected' : '' }}>Muerto</option>
                        </select>
                    </div>
                    <div class="col-md-1 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search"></i> Filtrar
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Tabla de animales -->
    <div class="card">
        <div class="card-header">
            <i class="fas fa-table"></i> Listado de Animales
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Código</th>
                            <th>Raza</th>
                            <th>Sexo</th>
                            <th>Lote</th>
                            <th>Edad</th>
                            <th>Peso Inicial</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($animales as $animal)
                            <tr>
                                <td>{{ $animal->codigo }}</td>
                                <td>{{ $animal->raza }}</td>
                                <td>{{ $animal->sexo }}</td>
                                <td>{{ $animal->lote->nombre ?? 'Sin lote' }}</td>
                                <td>
                                    @if($animal->fecha_nacimiento)
                                        {{ \Carbon\Carbon::parse($animal->fecha_nacimiento)->age }} años
                                    @else
                                        N/A
                                    @endif
                                </td>
                                <td>{{ $animal->peso_inicial ? $animal->peso_inicial.' kg' : 'N/A' }}</td>
                                <td>
                                    <span class="badge 
                                        @if($animal->estado == 'Activo') bg-success 
                                        @elseif($animal->estado == 'Vendido') bg-info 
                                        @elseif($animal->estado == 'Enfermo') bg-warning 
                                        @elseif($animal->estado == 'Muerto') bg-danger 
                                        @endif">
                                        {{ $animal->estado }}
                                    </span>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('animales.show', $animal) }}" class="btn btn-sm btn-info" title="Ver">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('animales.edit', $animal) }}" class="btn btn-sm btn-primary" title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('animales.destroy', $animal) }}" method="POST" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" title="Eliminar" onclick="return confirm('¿Estás seguro de eliminar este animal?')">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center">No se encontraron animales</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <!-- Paginación -->
            <div class="d-flex justify-content-center mt-3">
                {{ $animales->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
</div>
@endsection