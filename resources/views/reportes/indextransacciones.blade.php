@extends('layouts.layout')

@section('title', 'Gestión de Reportes')

@section('styles')
<style>
    @media print {
        body * {
            visibility: hidden;
        }
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
            display: none !important;
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
    }
</style>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-6">
            <h1 class="h3 mb-0 text-gray-800">
                <i class="fas fa-exchange-alt"></i> Transacciones Financieras Reportes
            </h1>
        </div>
        {{-- <div class="col-md-6 text-end">
            <a href="{{ route('transacciones.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Nueva Transacción
            </a>
        </div> --}}
    </div>

    <div class="card shadow mb-4 no-print"> {{-- Añadimos no-print aquí para ocultar los filtros al imprimir --}}
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Filtros</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('reportes.index') }}" method="GET">
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
                        <a href="{{ route('reportes.index') }}" class="btn btn-secondary">
                            <i class="fas fa-broom"></i> Limpiar
                        </a>
                        <button type="button" onclick="imprimirReporte()" class="btn btn-success">
                            <i class="fas fa-print"></i> Imprimir
                        </button>
                        {{-- <button type="button" onclick="generarPDF(event)" class="btn btn-danger">
                            <i class="fas fa-file-pdf"></i> Generar PDF
                        </button> --}}
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card shadow printable-area"> {{-- Clase para el área imprimible --}}
        <div class="card-body">
            <h4 class="text-center mb-3 no-print">Reporte de Transacciones Financieras</h4> {{-- Título para la impresión --}}
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="thead-light">
                        <tr>
                            <th>Fecha</th>
                            <th>Tipo</th>
                            <th>Finca</th>
                            <th>Descripción</th>
                            <th class="text-end">Monto</th>
                            <th>Moneda</th>
                            <th>Categoría</th>
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
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center">No se encontraron transacciones</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3 no-print"> {{-- Ocultar paginación al imprimir --}}
                {{ $transacciones->appends(request()->query())->links() }}
            </div>

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
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
<script>
    // Asegúrate de que jQuery y jQuery UI (para datepicker) estén cargados en layouts.layout
    $(document).ready(function() {
        // Configuración de datepicker
        $("#fecha_inicio, #fecha_fin").datepicker({
            dateFormat: 'yy-mm-dd',
            changeMonth: true,
            changeYear: true
        });
    });

    // Función de impresión global
    window.imprimirReporte = function() {
        // Clonamos el contenido para no modificar el DOM original mientras se imprime
        const originalContent = document.querySelector('.printable-area').cloneNode(true);
        const noPrintElements = originalContent.querySelectorAll('.no-print');
        
        // Removemos los elementos con la clase .no-print del clon antes de imprimir
        noPrintElements.forEach(el => el.remove());
        
        const printWindow = window.open('', '_blank');
        printWindow.document.write(`
            <!DOCTYPE html>
            <html>
                <head>
                    <title>Reporte de Transacciones</title>
                    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" integrity="sha384-..." crossorigin="anonymous">
                    <style>
                        body { font-family: Arial, sans-serif; margin: 1cm; }
                        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
                        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
                        th { background-color: #f2f2f2; }
                        .text-end { text-align: right; }
                        .badge { padding: 0.3em 0.6em; font-size: 85%; line-height: 1; border-radius: 0.25rem; }
                        .bg-success { background-color: #28a745!important; color: white; }
                        .bg-danger { background-color: #dc3545!important; color: white; }
                        h2 { text-align: center; margin-bottom: 20px; }
                        p { text-align: right; font-size: 0.9em; }
                    </style>
                </head>
                <body>
                    <h2>Reporte de Transacciones</h2>
                    <p>Generado el: ${new Date().toLocaleString()}</p>
                    ${originalContent.innerHTML}
                </body>
            </html>
        `);
        printWindow.document.close();
        setTimeout(() => printWindow.print(), 500);
    };

    // Función para generar PDF
    window.generarPDF = function(event) { // Pasamos el evento para poder acceder a event.target
        // Cambiar el texto del botón
        const btn = event.target;
        const originalText = btn.innerHTML;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Generando...';
        btn.disabled = true;
        
        // Obtener parámetros del formulario
        const form = document.querySelector('form');
        const formData = new FormData(form);
        const params = new URLSearchParams(formData).toString();
        
        // Redireccionar al controlador de PDF
        window.location.href = `{{ route('reportes.pdf') }}?${params}`;
        
        // Restaurar botón después de un tiempo prudencial (o al detectar la descarga del PDF si fuera posible)
        setTimeout(() => {
            btn.innerHTML = originalText;
            btn.disabled = false;
        }, 5000); // 5 segundos es un tiempo estimado, puedes ajustarlo
    };
</script>
@endpush