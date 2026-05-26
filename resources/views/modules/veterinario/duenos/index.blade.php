@extends('layouts.app')

@section('titulo_pagina', 'Gestión de Dueños | Sistema Veterinaria')

@section('contenido')

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><i class="fas fa-users"></i> Padrón de Dueños/Propietarios</h1>
        <a href="{{ route('duenos.create') }}" class="btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-plus fa-sm text-white-50"></i> Registrar Nuevo Dueño
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Listado de Propietarios Registrados</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped" width="100%" cellspacing="0">
                    <thead class="thead-light">
                        <tr>
                            <th>Nombre Completo</th>
                            <th>Teléfono</th>
                            <th>Dirección</th>
                            <th>Redes Sociales</th>
                            <th>Mascotas Reg.</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($duenos as $dueno)
                        <tr>
                            <td><strong>{{ $dueno->nombre_completo }}</strong></td>
                            <td>{{ $dueno->telefono }}</td>
                            <td>{{ $dueno->direccion }}</td>
                            <td>{{ $dueno->redes_sociales ?? 'N/A' }}</td>
                            <td class="text-center">
                                <span class="badge badge-info">{{ $dueno->mascotas_count }}</span>
                            </td>
                            <td>
                                <a href="{{ route('duenos.edit', $dueno->id) }}" class="btn btn-sm btn-warning btn-circle" title="Editar">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('duenos.destroy', $dueno->id) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Está seguro de eliminar a este propietario?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger btn-circle" title="Eliminar">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center">No hay propietarios registrados aún.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="d-flex justify-content-end mt-3">
                {{ $duenos->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>

@endsection
