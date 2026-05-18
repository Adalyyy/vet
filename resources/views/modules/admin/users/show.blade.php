@extends('layouts.admin')

@section('titulo_pagina', 'Eliminar Usuario | Panel de Administración')

@section('contenido')

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><i class="fas fa-trash-alt text-danger"></i> Eliminar Usuario</h1>
        <a href="{{ route('admin.users.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50"></i> Volver a la lista
        </a>
    </div>

    <!-- User Information and Delete Confirmation -->
    <div class="card shadow mb-4 border-left-danger">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-danger">Confirmación de Eliminación</h6>
        </div>
        <div class="card-body">
            
            <div class="alert alert-warning">
                <h5><i class="fas fa-exclamation-triangle"></i> ¡Advertencia!</h5>
                Estás a punto de eliminar al usuario <strong>{{ $user->name }}</strong>. 
                Esta acción <strong>no se puede deshacer</strong> y eliminará su cuenta de forma permanente.
                Si este usuario tiene datos registrados como citas o mascotas en el futuro, no podrás eliminarlo. Su perfil de veterinario (si tiene) se eliminará automáticamente.
            </div>

            <table class="table table-bordered mt-4">
                <tr>
                    <th width="200" class="bg-light">ID de Usuario</th>
                    <td>{{ $user->id }}</td>
                </tr>
                <tr>
                    <th class="bg-light">Nombre Completo</th>
                    <td>{{ $user->name }}</td>
                </tr>
                <tr>
                    <th class="bg-light">Correo Electrónico</th>
                    <td>{{ $user->email }}</td>
                </tr>
                <tr>
                    <th class="bg-light">Rol en el Sistema</th>
                    <td>
                        <span class="badge {{ $user->rol == 'administrador' ? 'badge-primary' : 'badge-success' }}">
                            {{ ucfirst($user->rol) }}
                        </span>
                    </td>
                </tr>
                <tr>
                    <th class="bg-light">Fecha de Registro</th>
                    <td>{{ $user->created_at->format('d/m/Y H:i A') }}</td>
                </tr>
            </table>

            <hr>

            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="d-inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">
                    <i class="fas fa-trash"></i> Sí, estoy seguro de eliminar este usuario
                </button>
            </form>
            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary ml-2">
                Cancelar
            </a>
        </div>
    </div>

@endsection
