
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-6">
            <h1 class="h3 mb-0 text-gray-800">
                <i class="fas fa-map-marked-alt"></i> Agregar Nuevo Lote
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
            <form action="{{ route('lotes.store') }}" method="POST" id="loteForm">
                @csrf
                
                <div class="row">
                    <div class="col-md-6">
                        <!-- Campo Finca -->
                        <div class="form-group mb-3">
                            <label for="finca_id" class="form-label">Finca <span class="text-danger">*</span></label>
                            <select name="finca_id" id="finca_id" class="form-control select2 @error('finca_id') is-invalid @enderror" required>
                                <option value="">Seleccione una finca</option>
                                @foreach($fincas as $finca)
                                    <option value="{{ $finca->id }}" {{ old('finca_id') == $finca->id ? 'selected' : '' }}>
                                        {{ $finca->nombre }} ({{ $finca->ubicacion }})
                                    </option>
                                @endforeach
                            </select>
                            @error('finca_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Campo Nombre -->
                        <div class="form-group mb-3">
                            <label for="nombre" class="form-label">Nombre del Lote <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('nombre') is-invalid @enderror" 
                                   id="nombre" name="nombre" value="{{ old('nombre') }}" required>
                            @error('nombre')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Campo Propósito -->
                        <div class="form-group mb-3">
                            <label for="proposito" class="form-label">Propósito <span class="text-danger">*</span></label>
                            <select name="proposito" id="proposito" class="form-control @error('proposito') is-invalid @enderror" required>
                                <option value="">Seleccione un propósito</option>
                                <option value="Cría" {{ old('proposito') == 'Cría' ? 'selected' : '' }}>Cría</option>
                                <option value="Engorde" {{ old('proposito') == 'Engorde' ? 'selected' : '' }}>Engorde</option>
                                <option value="Leche" {{ old('proposito') == 'Leche' ? 'selected' : '' }}>Leche</option>
                                <option value="Reproducción" {{ old('proposito') == 'Reproducción' ? 'selected' : '' }}>Reproducción</option>
                                
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
                                       value="{{ old('capacidad_maxima') }}" min="1" required>
                                <span class="input-group-text">animales</span>
                            </div>
                            @error('capacidad_maxima')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">La capacidad no puede superar la disponible en la finca seleccionada</small>
                        </div>

                        <!-- Campo Descripción -->
                        <div class="form-group mb-3">
                            <label for="descripcion" class="form-label">Descripción</label>
                            <textarea class="form-control @error('descripcion') is-invalid @enderror" 
                                      id="descripcion" name="descripcion" rows="3">{{ old('descripcion') }}</textarea>
                            @error('descripcion')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-md-12 text-end">
                        <button type="reset" class="btn btn-secondary">
                            <i class="fas fa-undo"></i> Limpiar
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Guardar Lote
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>


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

        // Validación de capacidad máxima según finca seleccionada
        const capacidadInput = document.getElementById('capacidad_maxima');
        const fincaSelect = document.getElementById('finca_id');
        
        fincaSelect.addEventListener('change', function() {
            if (this.value) {
                // Aquí podrías hacer una petición AJAX para obtener la capacidad disponible de la finca
                // y establecer el máximo permitido en el input de capacidad
                // Ejemplo:
                // fetch(`/api/fincas/${this.value}/capacidad`)
                //     .then(response => response.json())
                //     .then(data => {
                //         capacidadInput.max = data.capacidad_disponible;
                //     });
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

            if (!isValid) {
                e.preventDefault();
                Swal.fire({
                    icon: 'error',
                    title: 'Campos incompletos',
                    text: 'Por favor complete todos los campos requeridos',
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
</style>
@endpush