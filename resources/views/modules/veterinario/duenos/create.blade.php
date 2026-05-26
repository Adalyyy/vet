@extends('layouts.app')

@section('titulo_pagina', 'Registrar Dueño | Sistema Veterinaria')

@section('contenido')

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Registrar Nuevo Dueño</h1>
        <a href="{{ route('duenos.index') }}" class="btn btn-sm btn-secondary shadow-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50"></i> Volver al listado
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Formulario de Registro</h6>
        </div>
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <strong>Error:</strong> Por favor corrige los siguientes errores:<br><br>
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('duenos.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="nombre_completo" class="font-weight-bold">Nombre Completo <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('nombre_completo') is-invalid @enderror" id="nombre_completo" name="nombre_completo" value="{{ old('nombre_completo') }}" required>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label for="telefono" class="font-weight-bold">Teléfono de Contacto <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('telefono') is-invalid @enderror" id="telefono" name="telefono" value="{{ old('telefono') }}" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label for="direccion" class="font-weight-bold">Dirección Completa <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('direccion') is-invalid @enderror" id="direccion" name="direccion" rows="3" required>{{ old('direccion') }}</textarea>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 mb-4">
                        <label for="redes_sociales" class="font-weight-bold">Redes Sociales / Notas Adicionales (Opcional)</label>
                        <input type="text" class="form-control @error('redes_sociales') is-invalid @enderror" id="redes_sociales" name="redes_sociales" value="{{ old('redes_sociales') }}" placeholder="Ej. Facebook: /juan.perez, Instagram: @juanp">
                    </div>
                </div>

                <hr class="mt-4 mb-4">
                
                <h5 class="text-primary font-weight-bold mb-3"><i class="fas fa-paw"></i> Registrar Primera Mascota</h5>
                <p class="text-muted small">Es obligatorio registrar al menos una mascota al dar de alta a un nuevo propietario.</p>
                
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="mascota_nombre" class="font-weight-bold">Nombre de la mascota <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="mascota_nombre" name="mascota_nombre" value="{{ old('mascota_nombre') }}" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="mascota_especie" class="font-weight-bold">Especie (Ej. Perro, Gato) <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="mascota_especie" name="mascota_especie" value="{{ old('mascota_especie') }}" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="mascota_raza" class="font-weight-bold">Raza <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="mascota_raza" name="mascota_raza" value="{{ old('mascota_raza') }}" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-3 mb-3">
                        <label for="mascota_fecha_nacimiento" class="font-weight-bold">F. Nacimiento / Adopción <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" id="mascota_fecha_nacimiento" name="mascota_fecha_nacimiento" value="{{ old('mascota_fecha_nacimiento') }}">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="mascota_edad" class="font-weight-bold">Edad (Meses/Años)</label>
                        <input type="text" class="form-control" id="mascota_edad" name="mascota_edad" value="{{ old('mascota_edad') }}" placeholder="Ej. 6 meses, 3 años">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="mascota_tipo_sangre" class="font-weight-bold">Tipo de Sangre</label>
                        <input type="text" class="form-control" id="mascota_tipo_sangre" name="mascota_tipo_sangre" value="{{ old('mascota_tipo_sangre') }}">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="mascota_comportamiento" class="font-weight-bold">Comportamiento</label>
                        <input type="text" class="form-control" id="mascota_comportamiento" name="mascota_comportamiento" value="{{ old('mascota_comportamiento') }}">
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-12">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="mascota_es_adoptado" name="mascota_es_adoptado" {{ old('mascota_es_adoptado') ? 'checked' : '' }}>
                            <label class="custom-control-label" for="mascota_es_adoptado">¿Es adoptado?</label>
                        </div>
                    </div>
                </div>

                <hr>
                
                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Guardar Registro Completo</button>
                <a href="{{ route('duenos.index') }}" class="btn btn-secondary">Cancelar</a>
            </form>
        </div>
    </div>

@endsection
