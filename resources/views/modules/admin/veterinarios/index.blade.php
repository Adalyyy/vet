@extends('layouts.admin')

@section('titulo_pagina', 'Gestión de Veterinarios | Panel de Administración')

@section('contenido')

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><i class="fas fa-user-md"></i> Gestión de Veterinarios</h1>
        <a href="{{ route('admin.veterinarios.create') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-plus fa-sm text-white-50"></i> Nuevo Veterinario
        </a>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Lista de Veterinarios</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Nombre Completo</th>
                            <th>Teléfono</th>
                            <th>Cédula Profesional</th>
                            <th>Año Antigüedad</th>
                            <th>Especialidad</th>
                            <th>Usuario (Sistema)</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($veterinarios as $vet)
                        <tr>
                            <td>{{ $vet->nombre_completo }}</td>
                            <td>{{ $vet->telefono }}</td>
                            <td>{{ $vet->cedula_profesional }}</td>
                            <td>{{ $vet->anio_antiguedad }} años</td>
                            <td>{{ $vet->especialidad }}</td>
                            <td>{{ $vet->user->email ?? 'N/A' }}</td>
                            <td>
                                <a href="{{ route('admin.veterinarios.edit', $vet->id) }}" class="btn btn-warning btn-sm" title="Editar"><i class="fas fa-edit"></i></a>
                                <a href="{{ route('admin.veterinarios.show', $vet->id) }}" class="btn btn-danger btn-sm" title="Eliminar"><i class="fas fa-trash"></i></a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <div class="d-flex justify-content-end mt-3">
                {{ $veterinarios->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>

@endsection
