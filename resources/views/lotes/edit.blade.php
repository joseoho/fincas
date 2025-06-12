@extends('layouts.layout')

@section('title', 'Editar Lote')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-6">
            <h1 class="h3 mb-0 text-gray-800">
                <i class="fas fa-map-marked-alt"></i> Editar Lote: {{ $lote->nombre }}
            </h1>
        </div>
        <div class="col-md-6 text-end">
            <a href="{{ route('lotes.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Regresar
            </a>
        </div>
    </div>

    <div class="card shadow">
        <div class="card-body">
            <form action="{{ route('lotes.update', $lote->id) }}" method="POST" id="loteForm">
                @csrf
                @method('PUT')
                
                <div class="row">
                    <div class="col-md-6">
                        <!-- Campo Finca (solo lectura si ya tiene animales) -->
                        <div class="form-group mb-3">
                            <label for="finca_id" class="form-label">Finca <span class="text-danger">*</span></label>
                            @if($lote->animales_count > 0)
                                <input type="hidden" name="finca_id" value="{{ $lote->finca_id }}">
                                <select id="finca_id" class="form-control" disabled>
                                    <option value="{{ $lote->finca_id }}" selected>
                                        {{ $lote->finca->nombre }} ({{ $lote->finca->ubicacion }})
                                    </option>
                                </select>
                                <small class="text-muted">No se puede cambiar la finca porque el lote contiene animales</small>
                            @else
                                <select name="finca_id" id="finca_id" class="form-control select2 @error('finca_id') is-invalid @enderror" required>
                                    <option value="">Seleccione una finca</option>
                                    @foreach($fincas as $finca)
                                        <option value="{{ $finca->id }}" {{ old('finca_id', $lote->finca_id) == $finca->id ? 'selected' : '' }}>
                                            {{ $finca->nombre }} ({{ $finca->ubicacion }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('finca_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            @endif
                        </div>

                        <!-- Campo Nombre -->
                        <div class="form-group mb-3">
                            <label for="nombre" class="form-label">Nombre del Lote <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('nombre') is-invalid @enderror" 
                                   id="nombre" name="nombre" value="{{ old('nombre', $lote->nombre) }}" required>
                            @error('nombre')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Campo Propósito -->
                        <div class="form-group mb-3">
                            <label for="proposito" class="form-label">Propósito <span class="text-danger">*</span></label>
                            <select name="proposito" id="proposito" class="form-control @error('proposito') is-invalid @enderror" required>
                                <option value="">Seleccione un propósito</option>
                                <option value="Cría" {{ old('proposito', $lote->proposito) == 'Cría' ? 'selected' : '' }}>Cría</option>
                                <option value="Engorde" {{ old('proposito', $lote->proposito) == 'Engorde' ? 'selected' : '' }}>Engorde</option>
                                <option value="Leche" {{ old('proposito', $lote->proposito) == 'Leche' ? 'selected' : '' }}>Leche</option>
                                <option value="Reproducción" {{ old('proposito', $lote->proposito) == 'Reproducción' ? 'selected' : '' }}>Reproducción</option>
                                
                            </select>
                            @error('proposito')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <!-- Campo Capacidad Máxima -->
                        <div class="form-group mb-3">
                            <label for="capacidad_maxima" class="form-label">Capacidad Máxima <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="number" class="form-control @error('capacidad_maxima') is-invalid @enderror" 
                                       id="capacidad_maxima" name="capacidad_maxima" 
                                       value="{{ old('capacidad_maxima', $lote->capacidad_maxima) }}" 
                                       min="1" required>
                                <span class="input-group-text">animales</span>
                            </div>
                            @error('capacidad_maxima')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="mt-2">
                                <span class="badge bg-{{ $lote->animales_count > $lote->capacidad_maxima ? 'danger' : 'info' }}">
                                    Actual: {{ $lote->animales_count }} animales
                                </span>
                            </div>
                            <small class="text-muted">La capacidad no puede ser menor que la cantidad actual de animales ({{ $lote->animales_count }})</small>
                        </div>

                        <!-- Campo Descripción -->
                        <div class="form-group mb-3">
                            <label for="descripcion" class="form-label">Descripción</label>
                            <textarea class="form-control @error('descripcion') is-invalid @enderror" 
                                      id="descripcion" name="descripcion" rows="3">{{ old('descripcion', $lote->descripcion) }}</textarea>
                            @error('descripcion')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-md-12 text-end">
                        <button type="reset" class="btn btn-secondary">
                            <i class="fas fa-undo"></i> Restablecer
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Actualizar Lote
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Inicializar Select2 si está incluido en tu proyecto
        if ($().select2) {
            $('#finca_id').select2({
                placeholder: "Seleccione una finca",
                allowClear: true
            });
        }

        // Validación de capacidad máxima
        const capacidadInput = document.getElementById('capacidad_maxima');
        const animalesActuales = {{ $lote->animales_count }};
        
        capacidadInput.addEventListener('change', function() {
            if (this.value < animalesActuales) {
                this.classList.add('is-invalid');
                const errorDiv = document.createElement('div');
                errorDiv.className = 'invalid-feedback';
                errorDiv.textContent = `La capacidad no puede ser menor que los animales actuales (${animalesActuales})`;
                
                if (!this.nextElementSibling.classList.contains('invalid-feedback')) {
                    this.parentNode.insertBefore(errorDiv, this.nextElementSibling);
                }
            } else {
                this.classList.remove('is-invalid');
                if (this.nextElementSibling.classList.contains('invalid-feedback')) {
                    this.nextElementSibling.remove();
                }
            }
        });

        // Validación del formulario antes de enviar
        document.getElementById('loteForm').addEventListener('submit', function(e) {
            let isValid = true;
            
            // Validar que todos los campos requeridos estén completos
            this.querySelectorAll('[required]').forEach(input => {
                if (!input.value.trim()) {
                    input.classList.add('is-invalid');
                    isValid = false;
                }
            });

            // Validar capacidad mínima
            if (parseInt(capacidadInput.value) < animalesActuales) {
                capacidadInput.classList.add('is-invalid');
                isValid = false;
            }

            if (!isValid) {
                e.preventDefault();
                Swal.fire({
                    icon: 'error',
                    title: 'Error en el formulario',
                    text: 'Por favor corrija los errores antes de continuar',
                });
            }
        });
    });
</script>
@endpush

@push('styles')
<style>
    .select2-container--default .select2-selection--single {
        height: calc(2.25rem + 2px);
        padding: .375rem .75rem;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: calc(2.25rem + 2px);
    }
    .select2-container .select2-selection--single .select2-selection__rendered {
        padding-left: 0;
    }
    .badge {
        font-size: 0.9em;
    }
</style>
@endpush