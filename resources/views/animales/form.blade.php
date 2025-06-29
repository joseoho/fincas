



            <div class="card">
                <div class="card-header">
                    <h2>Crear Nuevo Animal</h2>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('animales.store') }}">
                        @csrf
                        
                        <div class="row mb-3">
                            <label for="lote_id" class="col-md-4 col-form-label text-md-end">Lote</label>
                            <div class="col-md-6">
                                <select id="lote_id" class="form-control @error('lote_id') is-invalid @enderror" name="lote_id" required>
                                    <option value="">Seleccione un lote</option>
                                    @foreach($lotes as $lote)
                                        <option value="{{ $lote->id }}" {{ old('lote_id') == $lote->id ? 'selected' : '' }}>{{ $lote->nombre }}</option>
                                    @endforeach
                                </select>
                                @error('lote_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <label for="codigo" class="col-md-4 col-form-label text-md-end">Código</label>
                            <div class="col-md-6">
                                <input id="codigo" type="number" class="form-control @error('codigo') is-invalid @enderror" name="codigo" value="{{ old('codigo') }}" required autofocus>
                                @error('codigo')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        

                        <div class="row mb-3">
                            <label for="lote_id" class="col-md-4 col-form-label text-md-end">Raza</label>
                            <div class="col-md-6">
                                <select id="raza" class="form-control @error('raza') is-invalid @enderror" name="raza" required>
                                    <option value="">Seleccione una Raza</option>
                                    @foreach($razas as $raza)
                                        <option value="{{ $raza }}">{{ $raza }}</option>
                                    @endforeach
                                </select>
                                @error('lote_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="sexo" class="col-md-4 col-form-label text-md-end">Sexo</label>
                            <div class="col-md-6">
                                <select id="sexo" class="form-control @error('sexo') is-invalid @enderror" name="sexo" required>
                                    <option value="">Seleccione sexo</option>
                                    <option value="Macho" {{ old('sexo') == 'Macho' ? 'selected' : '' }}>Macho</option>
                                    <option value="Hembra" {{ old('sexo') == 'Hembra' ? 'selected' : '' }}>Hembra</option>
                                </select>
                                @error('sexo')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="fecha_nacimiento" class="col-md-4 col-form-label text-md-end">Fecha Nacimiento</label>
                            <div class="col-md-6">
                                <input id="fecha_nacimiento" type="date" class="form-control @error('fecha_nacimiento') is-invalid @enderror" name="fecha_nacimiento" value="{{ old('fecha_nacimiento') }}">
                                @error('fecha_nacimiento')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="peso_inicial" class="col-md-4 col-form-label text-md-end">Peso Inicial (kg)</label>
                            <div class="col-md-6">
                                <input id="peso_inicial" type="number" step="0.01" class="form-control @error('peso_inicial') is-invalid @enderror" name="peso_inicial" value="{{ old('peso_inicial') }}">
                                @error('peso_inicial')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="estado" class="col-md-4 col-form-label text-md-end">Estado</label>
                            <div class="col-md-6">
                                <select id="estado" class="form-control @error('estado') is-invalid @enderror" name="estado" required>
                                    <option value="Activo" {{ old('estado') == 'Activo' ? 'selected' : '' }}>Activo</option>
                                    <option value="Vendido" {{ old('estado') == 'Vendido' ? 'selected' : '' }}>Vendido</option>
                                    <option value="Enfermo" {{ old('estado') == 'Enfermo' ? 'selected' : '' }}>Enfermo</option>
                                    <option value="Muerto" {{ old('estado') == 'Muerto' ? 'selected' : '' }}>Muerto</option>
                                </select>
                                @error('estado')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="observaciones" class="col-md-4 col-form-label text-md-end">Observaciones</label>
                            <div class="col-md-6">
                                <textarea id="observaciones" class="form-control @error('observaciones') is-invalid @enderror" name="observaciones">{{ old('observaciones') }}</textarea>
                                @error('observaciones')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    Guardar Animal
                                </button>
                                <a href="{{ route('animales.index') }}" class="btn btn-secondary">
                                    Cancelar
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
    

