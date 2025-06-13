@extends('layouts.layout')

@section('content')

            <div class="card">
                <div class="card-header bg-primary text-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <h2 class="mb-0">Editar Animal: {{ $animal->codigo }}</h2>
                        <a href="{{ route('animales.show', $animal) }}" class="btn btn-light btn-sm">
                            <i class="fas fa-arrow-left"></i> Volver
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('animales.update', $animal) }}">
                        @csrf
                        @method('PUT')

                        <!-- Código del Animal -->
                        {{-- <div class="mb-3 row">
                            <label for="codigo" class="col-md-4 col-form-label text-md-end">Código</label>
                            <div class="col-md-6">
                                <input id="codigo" type="text" class="form-control @error('codigo') is-invalid @enderror" 
                                       name="codigo" value="{{ old('codigo', $animal->codigo) }}" required autofocus readonly>
                                @error('codigo')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div> --}}

                        <!-- Selección de Lote -->
                        <div class="mb-3 row">
                            <label for="lote_id" class="col-md-4 col-form-label text-md-end">Lote</label>
                            <div class="col-md-6">
                                <select id="lote_id" class="form-control @error('lote_id') is-invalid @enderror" 
                                        name="lote_id" required>
                                    <option value="">Seleccione un lote</option>
                                    @foreach($lotes as $lote)
                                        <option value="{{ $lote->id }}" 
                                            {{ old('lote_id', $animal->lote_id) == $lote->id ? 'selected' : '' }}>
                                            {{ $lote->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('lote_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <!-- Raza -->
                        <div class="mb-3 row">
                            <label for="raza" class="col-md-4 col-form-label text-md-end">Raza</label>
                            <div class="col-md-6">
                                <input id="raza" type="text" class="form-control @error('raza') is-invalid @enderror" 
                                       name="raza" value="{{ old('raza', $animal->raza) }}" required>
                                @error('raza')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <!-- Sexo -->
                        <div class="mb-3 row">
                            <label for="sexo" class="col-md-4 col-form-label text-md-end">Sexo</label>
                            <div class="col-md-6">
                                <select id="sexo" class="form-control @error('sexo') is-invalid @enderror" 
                                        name="sexo" required>
                                    <option value="Macho" {{ old('sexo', $animal->sexo) == 'Macho' ? 'selected' : '' }}>Macho</option>
                                    <option value="Hembra" {{ old('sexo', $animal->sexo) == 'Hembra' ? 'selected' : '' }}>Hembra</option>
                                </select>
                                @error('sexo')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <!-- Fecha de Nacimiento -->
                        <div class="mb-3 row">
                            <label for="fecha_nacimiento" class="col-md-4 col-form-label text-md-end">Fecha Nacimiento</label>
                            <div class="col-md-6">
                                <input id="fecha_nacimiento" type="date" 
                                       class="form-control @error('fecha_nacimiento') is-invalid @enderror" 
                                       name="fecha_nacimiento" value="{{ old('fecha_nacimiento', $animal->fecha_nacimiento ? $animal->fecha_nacimiento: '') }}">
                                @error('fecha_nacimiento')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <!-- Peso Inicial -->
                        <div class="mb-3 row">
                            <label for="peso_inicial" class="col-md-4 col-form-label text-md-end">Peso Inicial (kg)</label>
                            <div class="col-md-6">
                                <input id="peso_inicial" type="number" step="0.01" 
                                       class="form-control @error('peso_inicial') is-invalid @enderror" 
                                       name="peso_inicial" value="{{ old('peso_inicial', $animal->peso_inicial) }}">
                                @error('peso_inicial')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <!-- Estado -->
                        <div class="mb-3 row">
                            <label for="estado" class="col-md-4 col-form-label text-md-end">Estado</label>
                            <div class="col-md-6">
                                <select id="estado" class="form-control @error('estado') is-invalid @enderror" 
                                        name="estado" required>
                                    <option value="Activo" {{ old('estado', $animal->estado) == 'Activo' ? 'selected' : '' }}>Activo</option>
                                    <option value="Vendido" {{ old('estado', $animal->estado) == 'Vendido' ? 'selected' : '' }}>Vendido</option>
                                    <option value="Enfermo" {{ old('estado', $animal->estado) == 'Enfermo' ? 'selected' : '' }}>Enfermo</option>
                                    <option value="Muerto" {{ old('estado', $animal->estado) == 'Muerto' ? 'selected' : '' }}>Muerto</option>
                                </select>
                                @error('estado')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <!-- Observaciones -->
                        <div class="mb-3 row">
                            <label for="observaciones" class="col-md-4 col-form-label text-md-end">Observaciones</label>
                            <div class="col-md-6">
                                <textarea id="observaciones" rows="3" 
                                          class="form-control @error('observaciones') is-invalid @enderror" 
                                          name="observaciones">{{ old('observaciones', $animal->observaciones) }}</textarea>
                                @error('observaciones')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <!-- Botones de Acción -->
                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Guardar Cambios
                                </button>
                                <a href="{{ route('animales.show', $animal) }}" class="btn btn-secondary">
                                    Cancelar
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

@endsection