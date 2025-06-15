@extends('layouts.layout')

@section('styles')
<style>
    @media print {
        .no-print { display: none !important; }
        .printable-area { width: 100% !important; }
    }
    .export-options { background: #f8f9fa; padding: 15px; border-radius: 5px; }
</style>
@endsection

@section('content')
<div class="container py-4">
    <div class="card no-print">
        <div class="card-header bg-primary text-white">
            <h2 class="h5 mb-0">Reportes de Transacciones</h2>
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
                        <button type="button" onclick="imprimirListado()" class="btn btn-success">
                        <i class="fas fa-print"></i> Imprimir
                        </button>
                        <button type="button" onclick="generarPDF()" class="btn btn-danger">
                            <i class="fas fa-file-pdf"></i> Generar PDF
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
            <!-- Área Imprimible -->
            <div class="printable-area">
                @include('reportes.reporte_tabla', ['transacciones' => $transacciones, 'totales' => $totales])
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function imprimirReporte() {
        const originalContent = document.querySelector('.printable-area').cloneNode(true);
        const noPrintElements = originalContent.querySelectorAll('.no-print');
        noPrintElements.forEach(el => el.remove());
        
        const printWindow = window.open('', '_blank');
        printWindow.document.write(`
            <!DOCTYPE html>
            <html>
                <head>
                    <title>Reporte de Transacciones</title>
                    <style>
                        body { font-family: Arial; margin: 1cm; }
                        table { width: 100%; border-collapse: collapse; }
                        th, td { border: 1px solid #ddd; padding: 8px; }
                        .text-right { text-align: right; }
                        .text-center { text-align: center; }
                    </style>
                </head>
                <body>
                    <h2>Reporte de Transacciones</h2>
                    <p>Fecha: ${new Date().toLocaleDateString()}</p>
                    ${originalContent.innerHTML}
                </body>
            </html>
        `);
        printWindow.document.close();
        setTimeout(() => printWindow.print(), 500);
    }
    
    function generarPDF() {
        // Serializar los datos del formulario
        const formData = new FormData(document.getElementById('reporteForm'));
        const searchParams = new URLSearchParams(formData).toString();
        
        // Mostrar spinner de carga
        const originalText = event.target.innerHTML;
        event.target.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Generando...';
        
        // Enviar solicitud para generar PDF
        fetch(`{{ route('transacciones.generar.pdf') }}?${searchParams}`)
            .then(response => response.blob())
            .then(blob => {
                const url = window.URL.createObjectURL(blob);
                const a = document.createElement('a');
                a.href = url;
                a.download = 'reporte-transacciones.pdf';
                document.body.appendChild(a);
                a.click();
                window.URL.revokeObjectURL(url);
            })
            .finally(() => {
                event.target.innerHTML = originalText;
            });
    }
</script>

<!-- Incluir Laravel Echo para PDF (opcional) -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
@endsection