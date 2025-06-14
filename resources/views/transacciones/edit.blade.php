@extends('layouts.layout')

@section('content')

            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h2 class="h5 mb-0">Editar Transacción</h2>
                </div>

                <div class="card-body">
                    <form action="{{ route('transacciones.update', $transaccion) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="finca_id" class="form-label">Finca</label>
                                <select class="form-select @error('finca_id') is-invalid @enderror" id="finca_id" name="finca_id" required>
                                    <option value="">Seleccione una finca</option>
                                    @foreach($fincas as $finca)
                                        <option value="{{ $finca->id }}" {{ $transaccion->finca_id == $finca->id ? 'selected' : '' }}>
                                            {{ $finca->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('finca_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="moneda_id" class="form-label">Moneda</label>
                                <select class="form-select @error('moneda_id') is-invalid @enderror" id="moneda_id" name="moneda_id" required>
                                    <option value="">Seleccione una moneda</option>
                                    @foreach($monedas as $moneda)
                                        <option value="{{ $moneda->id }}" {{ $transaccion->moneda_id == $moneda->id ? 'selected' : '' }}>
                                            {{ $moneda->codigo }} - {{ $moneda->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('moneda_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="tipo" class="form-label">Tipo de Transacción</label>
                                <select class="form-select @error('tipo') is-invalid @enderror" id="tipo" name="tipo" required>
                                    <option value="ingreso" {{ $transaccion->tipo == 'ingreso' ? 'selected' : '' }}>Ingreso</option>
                                    <option value="egreso" {{ $transaccion->tipo == 'egreso' ? 'selected' : '' }}>Egreso</option>
                                </select>
                                @error('tipo')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="monto" class="form-label">Monto</label>
                                <input type="number" step="0.01" class="form-control @error('monto') is-invalid @enderror" 
                                       id="monto" name="monto" value="{{ old('monto', $transaccion->monto) }}" required>
                                @error('monto')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="fecha" class="form-label">Fecha</label>
                                <input type="date" class="form-control @error('fecha') is-invalid @enderror" 
                                       id="fecha" name="fecha" value="{{ old('fecha', $transaccion->fecha) }}" required>
                                @error('fecha')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="categoria" class="form-label">Categoría</label>
                                <select class="form-select @error('categoria') is-invalid @enderror" id="categoria" name="categoria" required>
                                    <option value="">Seleccione una categoría</option>
                                    @foreach($categorias as $categoria)
                                        <option value="{{ $categoria }}" {{ $transaccion->categoria == $categoria ? 'selected' : '' }}>
                                            {{ $categoria }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('categoria')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="descripcion" class="form-label">Descripción</label>
                            <textarea class="form-control @error('descripcion') is-invalid @enderror" 
                                      id="descripcion" name="descripcion" rows="3">{{ old('descripcion', $transaccion->descripcion) }}</textarea>
                            @error('descripcion')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="referencia" class="form-label">Referencia (Opcional)</label>
                            <input type="text" class="form-control @error('referencia') is-invalid @enderror" 
                                   id="referencia" name="referencia" value="{{ old('referencia', $transaccion->referencia) }}">
                            @error('referencia')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="{{ route('transacciones.index') }}" class="btn btn-secondary me-md-2">
                                <i class="fas fa-times"></i> Cancelar
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Actualizar Transacción
                            </button>
                        </div>
                    </form>
                </div>
            </div>
   
@endsection

@section('scripts')
@if($errors->any())
<script>
    // Desplazar al primer campo con error
    document.addEventListener('DOMContentLoaded', function() {
        const firstErrorField = document.querySelector('.is-invalid');
        if (firstErrorField) {
            firstErrorField.scrollIntoView({ behavior: 'smooth', block: 'center' });
            firstErrorField.focus();
        }
    });
</script>
@endif
@endsection