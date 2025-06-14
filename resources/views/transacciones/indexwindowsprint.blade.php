@extends('layouts.layout')

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
        .badge {
            color: white !important;
            padding: 2px 5px !important;
        }
    }
</style>
@endsection

@section('content')
<div class="container py-4">
    <div class="card no-print">
        <div class="card-header bg-primary text-white">
            <h2 class="h5 mb-0">Gestión de Transacciones</h2>
        </div>
        
        <div class="card-body">
            <!-- Formulario de Filtros -->
            <form method="GET" action="{{ route('transacciones.index') }}" class="mb-4">
                <div class="row g-3">
                    <div class="col-md-3">
                        <label for="search" class="form-label">Buscar</label>
                        <input type="text" class="form-control" id="search" name="search" 
                               value="{{ request('search') }}" placeholder="Descripción, referencia...">
                    </div>
                    
                    <div class="col-md-2">
                        <label for="tipo" class="form-label">Tipo</label>
                        <select class="form-select" id="tipo" name="tipo">
                            <option value="">Todos</option>
                            <option value="ingreso" {{ request('tipo') == 'ingreso' ? 'selected' : '' }}>Ingreso</option>
                            <option value="egreso" {{ request('tipo') == 'egreso' ? 'selected' : '' }}>Egreso</option>
                        </select>
                    </div>
                    
                    <div class="col-md-3">
                        <label for="finca_id" class="form-label">Finca</label>
                        <select class="form-select" id="finca_id" name="finca_id">
                            <option value="">Todas las fincas</option>
                            @foreach($fincas as $finca)
                                <option value="{{ $finca->id }}" {{ request('finca_id') == $finca->id ? 'selected' : '' }}>
                                    {{ $finca->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="col-md-2">
                        <label for="fecha_inicio" class="form-label">Fecha Inicio</label>
                        <input type="date" class="form-control" id="fecha_inicio" name="fecha_inicio" 
                               value="{{ request('fecha_inicio') }}">
                    </div>
                    
                    <div class="col-md-2">
                        <label for="fecha_fin" class="form-label">Fecha Fin</label>
                        <input type="date" class="form-control" id="fecha_fin" name="fecha_fin" 
                               value="{{ request('fecha_fin') }}">
                    </div>
                    
                    <div class="col-md-12">
                        <div class="btn-group" role="group">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-search"></i> Filtrar
                            </button>
                            
                            <a href="{{ route('transacciones.index') }}" class="btn btn-secondary">
                                <i class="fas fa-broom"></i> Limpiar
                            </a>
                            
                            <button type="button" onclick="window.print()" class="btn btn-success">
                                <i class="fas fa-print"></i> Imprimir
                            </button>
                        </div>
                    </div>
                </div>
            </form>
            
            <!-- Área Imprimible -->
            <div class="printable-area">
                <!-- Resumen de Totales -->
                <div class="row mb-4">
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header bg-success text-white">
                                Total Ingresos
                            </div>
                            <div class="card-body">
                                {{ number_format($totalesFiltrados['ingresos'], 2) }} {{ $monedas->first()->codigo ?? 'USD' }}
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header bg-danger text-white">
                                Total Egresos
                            </div>
                            <div class="card-body">
                                {{ number_format($totalesFiltrados['egresos'], 2) }} {{ $monedas->first()->codigo ?? 'USD' }}
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header bg-info text-white">
                                Saldo Actual
                            </div>
                            <div class="card-body">
                                {{ number_format($totalesFiltrados['saldo'], 2) }} {{ $monedas->first()->codigo ?? 'USD' }}
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Tabla de Transacciones -->
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="thead-dark">
                            <tr>
                                <th>Fecha</th>
                                <th>Referencia</th>
                                <th>Descripción</th>
                                <th>Finca</th>
                                <th>Tipo</th>
                                <th>Monto</th>
                                <th>Categoría</th>
                                <th class="no-print">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($transacciones as $transaccion)
                            <tr>
                                <td>{{ $transaccion->fecha }}</td>
                                <td>{{ $transaccion->referencia }}</td>
                                <td>{{ Str::limit($transaccion->descripcion, 30) }}</td>
                                <td>{{ $transaccion->finca->nombre }}</td>
                                <td>
                                    <span class="badge bg-{{ $transaccion->tipo == 'ingreso' ? 'success' : 'danger' }}">
                                        {{ ucfirst($transaccion->tipo) }}
                                    </span>
                                </td>
                                <td>{{ number_format($transaccion->monto, 2) }} {{ $transaccion->moneda->codigo }}</td>
                                <td>{{ $transaccion->categoria }}</td>
                                <td class="no-print">
                                    <div class="btn-group btn-group-sm" role="group">
                                        <a href="{{ route('transacciones.show', $transaccion) }}" class="btn btn-info" title="Ver">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('transacciones.edit', $transaccion) }}" class="btn btn-primary" title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('transacciones.destroy', $transaccion) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger" title="Eliminar" 
                                                    onclick="return confirm('¿Estás seguro de eliminar esta transacción?')">
                                                <i class="fas fa-trash-alt"></i>
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
                <div class="d-flex justify-content-center no-print">
                    {{ $transacciones->appends(request()->query())->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Definición explícita en el ámbito global
    window.imprimirListado = function() {
        // 1. Obtener el contenido a imprimir
        const originalContent = document.querySelector('.printable-area').cloneNode(true);
        
        // 2. Eliminar elementos no deseados
        const noPrintElements = originalContent.querySelectorAll('.no-print');
        noPrintElements.forEach(el => el.remove());
        
        // 3. Crear ventana de impresión
        const printWindow = window.open('', '_blank');
        
        // 4. Generar el HTML completo
        printWindow.document.write(`
            <!DOCTYPE html>
            <html>
                <head>
                    <title>Reporte de Transacciones</title>
                    <style>
                        body { font-family: Arial; margin: 1cm; }
                        h1 { color: #333; }
                        table { width: 100%; border-collapse: collapse; }
                        th, td { border: 1px solid #ddd; padding: 8px; }
                        th { background-color: #f2f2f2; }
                        .header { margin-bottom: 20px; }
                        .footer { margin-top: 20px; font-size: 12px; }
                    </style>
                </head>
                <body>
                    <div class="header">
                        <h1>Reporte de Transacciones</h1>
                        <p>Generado el: ${new Date().toLocaleString()}</p>
                    </div>
                    ${originalContent.innerHTML}
                    <div class="footer">
                        © ${new Date().getFullYear()} Sistema de Gestión de Fincas
                    </div>
                </body>
            </html>
        `);
        
        printWindow.document.close();
        
        // 5. Imprimir después de breve retraso
        setTimeout(() => {
            printWindow.print();
            printWindow.close();
        }, 500);
    };
</script>
@endsection