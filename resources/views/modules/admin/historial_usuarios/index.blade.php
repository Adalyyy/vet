@extends('layouts.admin')

@section('titulo_pagina', 'Historial de Usuarios Eliminados | Panel de Administración')

@section('contenido')

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><i class="fas fa-history"></i> Historial de Usuarios</h1>
    </div>

    <!-- DataTales Example -->
    <div class="card shadow mb-4 border-left-secondary">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-secondary">Usuarios y Veterinarios Eliminados del Sistema</h6>
        </div>
        <div class="card-body">
            <div class="alert alert-info">
                <strong><i class="fas fa-info-circle"></i> Información:</strong> 
                Este es un registro histórico. Los datos en esta vista son de solo lectura y no pueden ser eliminados de la base de datos permanentemente desde aquí.
            </div>

            <div class="table-responsive mt-4">
                <table class="table table-bordered text-muted" id="dataTable" width="100%" cellspacing="0">
                    <thead class="thead-light">
                        <tr>
                            <th>Nombre de Usuario</th>
                            <th>Correo</th>
                            <th>Rol</th>
                            <th>Datos de Veterinario (Si aplica)</th>
                            <th>Fecha de Eliminación</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($usuariosEliminados as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                <span class="badge badge-secondary">
                                    {{ ucfirst($user->rol) }}
                                </span>
                            </td>
                            <td>
                                @if($user->veterinario)
                                    <strong>Nombre:</strong> {{ $user->veterinario->nombre_completo }}<br>
                                    <strong>Cédula:</strong> {{ $user->veterinario->cedula_profesional }}<br>
                                    <strong>Especialidad:</strong> {{ $user->veterinario->especialidad }}
                                @else
                                    <span class="text-secondary"><em>No aplica</em></span>
                                @endif
                            </td>
                            <td>{{ $user->deleted_at->format('d/m/Y H:i A') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center">No hay registros eliminados en el historial.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="d-flex justify-content-end mt-3">
                {{ $usuariosEliminados->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>

@endsection
