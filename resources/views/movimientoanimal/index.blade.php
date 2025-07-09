@extends('layouts.layout')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-2 text-gray-800">Movimientos de Animales</h1>
    
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <a href="{{ route('movimientos.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Nuevo Movimiento
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Animal</th>
                            <th>Lote Anterior</th>
                            <th>Lote Nuevo</th>
                            <th>Fecha</th>
                            <th>Motivo</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($movimientos as $movimiento)
                        <tr>
                            <td>{{ $movimiento->id }}</td>
                            <td>{{ $movimiento->animal->codigo ?? 'N/A' }} ({{ $movimiento->animal->raza ?? 'N/A' }})</td>
                            <td>{{ $movimiento->loteOrigen->nombre ?? 'N/A' }}</td>
                            <td>{{ $movimiento->loteDestino->nombre }}</td>
                            <td>{{ $movimiento->fecha}}</td>
                            <td>{{ $movimiento->motivo }}</td>
                            <td>
                                <a href="{{ route('movimientos.show', $movimiento) }}" class="btn btn-sm btn-info">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $movimientos->links() }}
            </div>
        </div>
    </div>
</div>
@endsection