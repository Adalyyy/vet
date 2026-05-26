@extends('layouts.app')

@section('titulo_pagina', 'Padrón de Pacientes (Mascotas)')

@section('contenido')

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><i class="fas fa-paw"></i> Padrón de Pacientes (Mascotas)</h1>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Listado Global de Mascotas</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Nombre del Paciente</th>
                            <th>Especie / Raza</th>
                            <th>Dueño</th>
                            <th>Fecha de alta (Registro)</th>
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
                                <a href="{{ route('mascotas.antecedentes.index', $mascota->id) }}" class="btn btn-sm btn-warning mr-1" title="Antecedentes">
                                    <i class="fas fa-clipboard-list"></i> Antecedentes
                                </a>
                                <a href="{{ route('expedientes.consultas', $mascota->id) }}" class="btn btn-sm btn-primary mr-1" title="Carnet de Consultas">
                                    <i class="fas fa-book-medical"></i> Carnet
                                </a>
                                <a href="{{ route('mascotas.show', $mascota->id) }}" class="btn btn-sm btn-info" title="Expediente Clínico">
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
