@extends('layouts.admin')

@section('titulo_pagina', 'Eliminar Veterinario | Panel de Administración')

@section('contenido')

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><i class="fas fa-trash"></i> Eliminar Veterinario</h1>
        <a href="{{ route('admin.veterinarios.index') }}" class="btn btn-sm btn-secondary shadow-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50"></i> Volver a la lista
        </a>
    </div>

    <div class="card shadow mb-4 border-left-danger">
        <div class="card-header py-3 text-danger">
            <h6 class="m-0 font-weight-bold">Confirmación de Eliminación</h6>
        </div>
        <div class="card-body">
            <div class="alert alert-warning">
                <strong><i class="fas fa-exclamation-triangle"></i> ¡Advertencia!</strong><br>
                Si elimina el listado de este veterinario (<strong>{{ $veterinario->nombre_completo }}</strong>) tambien eliminara su acceso como usuario.
                Esta acción moverá el registro al historial y no se podrá deshacer fácilmente.
            </div>

            <table class="table table-bordered">
                <tr>
                    <th width="30%">Nombre Completo</th>
                    <td>{{ $veterinario->nombre_completo }}</td>
                </tr>
                <tr>
                    <th>Cédula Profesional</th>
                    <td>{{ $veterinario->cedula_profesional }}</td>
                </tr>
                <tr>
                    <th>Especialidad</th>
                    <td>{{ $veterinario->especialidad }}</td>
                </tr>
            </table>

            <form action="{{ route('admin.veterinarios.destroy', $veterinario->id) }}" method="POST" class="mt-4">
                @csrf
                @method('DELETE')
                <div class="d-flex justify-content-between">
                    <a href="{{ route('admin.veterinarios.index') }}" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Cancelar
                    </a>
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash"></i> Sí, eliminar veterinario
                    </button>
                </div>
            </form>
        </div>
    </div>

@endsection
