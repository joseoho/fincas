@extends('layouts.layout')

@section('styles')
<style>
    /* Estilos para impresión */
    @media print {
        body * {
            visibility: hidden; /* Oculta todo por defecto */
        }
        /* Ajuste: asegúrate de que el contenedor de la tabla y su contenido sean visibles */
        .printable-area, .printable-area * {
            visibility: visible;
        }
        .printable-area {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
        }
        .no-print {
            display: none !important; /* Oculta elementos específicos para impresión */
        }
        .table {
            width: 100% !important;
            font-size: 12px !important;
        }
        .card-header {
            background-color: #f8f9fa !important;
            color: #000 !important;
            border-bottom: 1px solid #dee2e6 !important;
        }
        /* Estilos específicos para badges en impresión */
        .badge.bg-success { background-color: #28a745!important; color: white !important; }
        .badge.bg-info { background-color: #17a2b8!important; color: white !important; }
        .badge.bg-warning { background-color: #ffc107!important; color: black !important; }
        .badge.bg-danger { background-color: #dc3545!important; color: white !important; }
    }
</style>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row mb-3">
        <div class="col">
            <h1>Gestión de Animales Reportes</h1>
        </div>
    </div>

    <div class="card mb-4 no-print">
        <div class="card-header">
            <i class="fas fa-filter"></i> Filtros
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('reportesanimales.index') }}">
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
                    <div class="col-12 mt-3 text-end">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-filter"></i> Filtrar
                        </button>
                        <a href="{{ route('reportesanimales.index') }}" class="btn btn-secondary">
                            <i class="fas fa-broom"></i> Limpiar
                        </a>
                        <button type="button" onclick="imprimirReporte()" class="btn btn-success">
                            <i class="fas fa-print"></i> Imprimir
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="printable-area">
        <div class="card"> {{-- Elimina la clase 'printable-area' de este div si el padre ya la tiene --}}
            <div class="card-header">
                <h4 class="text-center mb-0 no-print">Reporte de Animales</h4>
                <span class="no-print"><i class="fas fa-table"></i> Listado de Animales Reporte</span> {{-- Solo para la vista en pantalla --}}
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
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center">No se encontraron animales</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                <div class="d-flex justify-content-center mt-3 no-print">
                    {{ $animales->appends(request()->query())->links() }}
                </div>
            </div>
        </div>
    </div> {{-- Cierre de printable-area --}}
</div>
@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
<script>
    window.imprimirReporte = function() {
        // Asegúrate de que este selector '.printable-area' apunte al DIV correcto
        const printableArea = document.querySelector('.printable-area');

        if (!printableArea) {
            console.error("No se encontró el elemento con la clase 'printable-area'.");
            alert("No se pudo generar el reporte para impresión. El área imprimible no fue encontrada.");
            return;
        }

        const originalContent = printableArea.cloneNode(true);
        const noPrintElements = originalContent.querySelectorAll('.no-print');
        
        noPrintElements.forEach(el => el.remove());
        
        const printWindow = window.open('', '_blank');
        printWindow.document.write(`
            <!DOCTYPE html>
            <html>
                <head>
                    <title>Reporte de Animales</title>
                    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
                    <style>
                        body { font-family: Arial, sans-serif; margin: 1cm; }
                        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
                        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
                        th { background-color: #f2f2f2; }
                        .text-end { text-align: right; }
                        .badge { padding: 0.3em 0.6em; font-size: 85%; line-height: 1; border-radius: 0.25rem; }
                        .bg-success { background-color: #28a745!important; color: white !important; }
                        .bg-info { background-color: #17a2b8!important; color: white !important; }
                        .bg-warning { background-color: #ffc107!important; color: black !important; }
                        .bg-danger { background-color: #dc3545!important; color: white !important; }
                        h2 { text-align: center; margin-bottom: 20px; }
                        p { text-align: right; font-size: 0.9em; }
                    </style>
                </head>
                <body>
                    <h2>Reporte de Animales</h2>
                    <p>Generado el: ${new Date().toLocaleString()}</p>
                    ${originalContent.innerHTML}
                </body>
            </html>
        `);
        printWindow.document.close();
        setTimeout(() => printWindow.print(), 500);
    };
</script>
@endpush