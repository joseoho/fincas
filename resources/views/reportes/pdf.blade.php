<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Reporte de Transacciones</title>
    <style>
        body { font-family: Arial, sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; }
        th { background-color: #f2f2f2; }
        .text-right { text-align: right; }
        .badge { padding: 2px 5px; color: white; border-radius: 3px; }
        .bg-success { background-color: #28a745; }
        .bg-danger { background-color: #dc3545; }
        .header { margin-bottom: 20px; }
        .footer { margin-top: 20px; font-size: 12px; text-align: center; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Reporte de Transacciones</h1>
        <p>Generado el: {{ now()->format('d/m/Y H:i') }}</p>
        
        @if(!empty(array_filter($filtros)))
        <p><strong>Filtros aplicados:</strong></p>
        <ul>
            @if($filtros['search'] ?? false)
                <li>Búsqueda: "{{ $filtros['search'] }}"</li>
            @endif
            @if($filtros['tipo'] ?? false)
                <li>Tipo: {{ $filtros['tipo'] == 'ingreso' ? 'Ingreso' : 'Egreso' }}</li>
            @endif
            <!-- Más filtros... -->
        </ul>
        @endif
    </div>
    
    <table>
        <thead>
            <tr>
                <th>Fecha</th>
                <th>Tipo</th>
                <th>Finca</th>
                <th>Descripción</th>
                <th>Monto</th>
                <th>Moneda</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transacciones as $transaccion)
            <tr>
                <td>{{ $transaccion->fecha->format('d/m/Y') }}</td>
                <td>
                    <span class="badge {{ $transaccion->tipo == 'ingreso' ? 'bg-success' : 'bg-danger' }}">
                        {{ ucfirst($transaccion->tipo) }}
                    </span>
                </td>
                <td>{{ $transaccion->finca->nombre }}</td>
                <td>{{ $transaccion->descripcion }}</td>
                <td class="text-right">{{ number_format($transaccion->monto, 2) }}</td>
                <td>{{ $transaccion->moneda->codigo }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    
    <div class="footer">
        <p>Sistema de Gestión de Fincas - {{ date('Y') }}</p>
    </div>
</body>
</html>