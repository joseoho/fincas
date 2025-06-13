


<div class="container">
    <h2>Crear Transacción</h2>
    
    <form action="{{ route('transacciones.store') }}" method="POST">
        @csrf
        
        
        <div class="mb-3">
            <label class="form-label">Finca</label>
            <select name="finca_id" class="form-select">
                @foreach($fincas as $finca)
                    <option value="{{ $finca->id }}">{{ $finca->nombre }}</option>
                @endforeach
            </select>
        </div>
        
        <div class="mb-3">
            <label class="form-label">Moneda</label>
            <select name="moneda_id" class="form-select">
                @foreach($monedas as $moneda)
                    <option value="{{ $moneda->id }}">{{ $moneda->codigo }} - {{ $moneda->tipo }}</option>
                @endforeach
            </select>
        </div>
        
        <div class="mb-3">
            <label class="form-label">Tipo</label>
            <select name="tipo" class="form-select">
                <option value="ingreso">Ingreso</option>
                <option value="egreso">Egreso</option>
            </select>
        </div>
        
        <div class="mb-3">
            <label class="form-label">Monto</label>
            <input type="number" name="monto" class="form-control" step="0.01">
        </div>
        
        <div class="mb-3">
            <label class="form-label">Fecha</label>
            <input type="date" name="fecha" class="form-control">
        </div>
        
        <div class="mb-3">
            <label class="form-label">Descripción</label>
            <input type="text" name="descripcion" class="form-control">
        </div>
        
        <div class="mb-3">
            <label class="form-label">Categoría</label>
            <select name="categoria" class="form-select">
                @foreach($categorias as $categoria)
                    <option value="{{ $categoria }}">{{ $categoria }}</option>
                @endforeach
            </select>
        </div>
        
        <div class="mb-3">
            <label class="form-label">Referencia (opcional)</label>
            <input type="text" name="referencia" class="form-control">
        </div>
        
        <button type="submit" class="btn btn-primary">Guardar Transacción</button>
        <a href="{{ route('transacciones.index') }}" class="btn btn-secondary">
                                    Cancelar
                                </a>
    </form>
</div>
