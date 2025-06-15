<div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Fecha</th>
                <th>Referencia</th>
                <th>Descripción</th>
                <th>Tipo</th>
                <th class="text-right">Monto</th>
                <th>Finca</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transacciones as $transaccion)
            <tr>
                <td>{{ $transaccion->fecha }}</td>
                <td>{{ $transaccion->referencia }}</td>
                <td>{{ $transaccion->descripcion }}</td>
                <td>
                    <span class="badge bg-{{ $transaccion->tipo == 'ingreso' ? 'success' : 'danger' }}">
                        {{ ucfirst($transaccion->tipo) }}
                    </span>
                </td>
                <td class="text-right">
                    {{ number_format($transaccion->monto, 2) }} {{ $transaccion->moneda->codigo }}
                </td>
                <td>{{ $transaccion->finca->nombre }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Resumen de Totales -->
<div class="row mt-4">
    <div class="col-md-4">
        <div class="card">
            <div class="card-header bg-success text-white">
                Total Ingresos
            </div>
            <div class="card-body text-center">
                <h4 class="mb-0">{{ number_format($totales['ingresos'], 2) }} {{ $monedas->first()->codigo }}</h4>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-header bg-danger text-white">
                Total Egresos
            </div>
            <div class="card-body text-center">
                <h4 class="mb-0">{{ number_format($totales['egresos'], 2) }} {{ $monedas->first()->codigo }}</h4>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-header bg-info text-white">
                Saldo Neto
            </div>
            <div class="card-body text-center">
                <h4 class="mb-0">{{ number_format($totales['saldo'], 2) }} {{ $monedas->first()->codigo }}</h4>
            </div>
        </div>
    </div>
</div>