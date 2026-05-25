@extends('layouts.admin')

@section('titulo_pagina', 'Nuevo Veterinario | Panel de Administración')

@section('contenido')

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><i class="fas fa-plus"></i> Registrar Nuevo Veterinario</h1>
        <a href="{{ route('admin.veterinarios.index') }}" class="btn btn-sm btn-secondary shadow-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50"></i> Volver a la lista
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Datos del Veterinario</h6>
        </div>
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.veterinarios.store') }}" method="POST">
                @csrf
                
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="usuario_id">Usuario del Sistema <span class="text-danger">*</span></label>
                        <select name="usuario_id" id="usuario_id" class="form-control" required>
                            <option value="">Seleccione un usuario...</option>
                            @foreach($usuarios as $user)
                                <option value="{{ $user->id }}" {{ old('usuario_id') == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }} ({{ $user->email }})
                                </option>
                            @endforeach
                        </select>
                        <small class="form-text text-muted">Solo se muestran usuarios con rol 'veterinario' sin perfil asignado.</small>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="nombre_completo">Nombre Completo <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="nombre_completo" name="nombre_completo" value="{{ old('nombre_completo') }}" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="telefono">Número Telefónico <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="telefono" name="telefono" value="{{ old('telefono') }}" required>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="cedula_profesional">Cédula Profesional <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="cedula_profesional" name="cedula_profesional" value="{{ old('cedula_profesional') }}" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="anio_antiguedad">Año de Antigüedad <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" id="anio_antiguedad" name="anio_antiguedad" value="{{ old('anio_antiguedad') }}" min="0" required>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="especialidad">Especialidad o Rol Principal <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="especialidad" name="especialidad" value="{{ old('especialidad') }}" required>
                    </div>
                </div>

                <hr>
                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Guardar Veterinario</button>
                </div>
            </form>
        </div>
    </div>

@endsection
