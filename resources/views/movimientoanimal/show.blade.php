@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-3">
        <div class="col">
            <h1>Detalles del Animal</h1>
        </div>
        <div class="col text-end">
            <a href="{{ route('animales.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Volver al listado
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h3 class="mb-0">Información Básica</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <h5 class="text-muted">Código:</h5>
                                <p class="fs-4">{{ $animal->codigo }}</p>
                            </div>
                            
                            <div class="mb-3">
                                <h5 class="text-muted">Raza:</h5>
                                <p class="fs-4">{{ $animal->raza }}</p>
                            </div>
                            
                            <div class="mb-3">
                                <h5 class="text-muted">Sexo:</h5>
                                <p class="fs-4">{{ $animal->sexo }}</p>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <h5 class="text-muted">Estado:</h5>
                                <p class="fs-4">
                                    <span class="badge 
                                        @if($animal->estado == 'Activo') bg-success 
                                        @elseif($animal->estado == 'Vendido') bg-info 
                                        @elseif($animal->estado == 'Enfermo') bg-warning 
                                        @elseif($animal->estado == 'Muerto') bg-danger 
                                        @endif">
                                        {{ $animal->estado }}
                                    </span>
                                </p>
                            </div>
                            
                            <div class="mb-3">
                                <h5 class="text-muted">Fecha de Nacimiento:</h5>
                                <p class="fs-4">
                                    @if($animal->fecha_nacimiento)
                                        {{ \Carbon\Carbon::parse($animal->fecha_nacimiento)->format('d/m/Y') }}
                                        ({{ \Carbon\Carbon::parse($animal->fecha_nacimiento)->age }} años)
                                    @else
                                        N/A
                                    @endif
                                </p>
                            </div>
                            
                            <div class="mb-3">
                                <h5 class="text-muted">Peso Inicial:</h5>
                                <p class="fs-4">
                                    @if($animal->peso_inicial)
                                        {{ number_format($animal->peso_inicial, 2) }} kg
                                    @else
                                        N/A
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h3 class="mb-0">Ubicación</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <h5 class="text-muted">Lote Actual:</h5>
                                <p class="fs-4">
                                    @if($animal->lote)
                                        {{ $animal->lote->nombre }}
                                    @else
                                        Sin lote asignado
                                    @endif
                                </p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <h5 class="text-muted">Finca:</h5>
                                <p class="fs-4">
                                    @if($animal->finca)
                                        {{ $animal->finca->nombre }}
                                    @else
                                        Sin finca asignada
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            @if($animal->observaciones)
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h3 class="mb-0">Observaciones</h3>
                </div>
                <div class="card-body">
                    <p class="fs-5">{{ $animal->observaciones }}</p>
                </div>
            </div>
            @endif
        </div>
        
        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h3 class="mb-0">Acciones</h3>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('animales.edit', $animal) }}" class="btn btn-warning btn-lg">
                            <i class="fas fa-edit"></i> Editar Animal
                        </a>
                        
                        <form action="{{ route('animales.destroy', $animal) }}" method="POST" class="d-grid">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-lg" onclick="return confirm('¿Estás seguro de eliminar este animal?')">
                                <i class="fas fa-trash-alt"></i> Eliminar Animal
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h3 class="mb-0">Historial de Movimientos</h3>
                </div>
                <div class="card-body">
                    @if($animal->movimientos->count() > 0)
                        <div class="timeline">
                            @foreach($animal->movimientos as $movimiento)
                                <div class="timeline-item mb-3">
                                    <div class="timeline-badge 
                                        @if($movimiento->tipo == 'Entrada') bg-success
                                        @elseif($movimiento->tipo == 'Salida') bg-danger
                                        @else bg-info @endif">
                                        <i class="fas 
                                            @if($movimiento->tipo == 'Entrada') fa-arrow-down
                                            @elseif($movimiento->tipo == 'Salida') fa-arrow-up
                                            @else fa-exchange-alt @endif"></i>
                                    </div>
                                    <div class="timeline-content p-3">
                                        <h5 class="mb-1">{{ $movimiento->tipo }} - {{ $movimiento->motivo }}</h5>
                                        <p class="mb-1 text-muted">
                                            <small>
                                                <i class="far fa-calendar-alt"></i> 
                                                {{ $movimiento->fecha->format('d/m/Y') }}
                                            </small>
                                        </p>
                                        <p class="mb-0">
                                            @if($movimiento->lote)
                                                Lote: {{ $movimiento->lote->nombre }}
                                            @endif
                                            @if($movimiento->observaciones)
                                                <br>{{ $movimiento->observaciones }}
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="alert alert-info mb-0">
                            No hay movimientos registrados para este animal.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .timeline {
        position: relative;
        padding-left: 50px;
    }
    .timeline-item {
        position: relative;
    }
    .timeline-badge {
        position: absolute;
        left: -40px;
        top: 0;
        width: 30px;
        height: 30px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
    }
    .timeline-content {
        background-color: #f8f9fa;
        border-radius: 5px;
        border-left: 3px solid #dee2e6;
    }
</style>
@endsection