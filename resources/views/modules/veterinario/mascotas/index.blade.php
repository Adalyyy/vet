@extends('layouts.app')

@section('titulo_pagina', 'Mascotas Registradas')

@section('contenido')

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><i class="fas fa-dog"></i> Mascotas Registradas</h1>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Listado de Mascotas</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Especie / Raza</th>
                            <th>Dueño</th>
                            <th>Fecha de alta</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($mascotas as $mascota)
                        <tr>
                            <td><strong>{{ $mascota->nombre }}</strong></td>
                            <td>{{ $mascota->especie }} / {{ $mascota->raza }}</td>
                            <td>{{ $mascota->dueno->nombre ?? $mascota->dueno->nombre_completo ?? 'N/A' }}</td>
                            <td>{{ $mascota->created_at->format('d/m/Y') }}</td>
                            <td>
                                <a href="{{ route('mascotas.antecedentes.index', $mascota->id) }}" class="btn btn-sm btn-warning">
                                    <i class="fas fa-clipboard-list"></i> Antecedentes
                                </a>
                                <a href="{{ route('expedientes.consultas', $mascota->id) }}" class="btn btn-sm btn-info">
                                    <i class="fas fa-notes-medical"></i> Expediente
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center">No hay mascotas registradas aún.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="d-flex justify-content-end mt-3">
                {{ $mascotas->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>

@endsection
