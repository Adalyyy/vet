@extends('layouts.app')

@section('titulo_pagina', 'Atender Mascota | Directorio Clínico')

@section('contenido')

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><i class="fas fa-notes-medical"></i> Atender Mascota</h1>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Directorio Clínico de Pacientes Activos</h6>
            
            <form action="{{ route('atender.index') }}" method="GET" class="form-inline">
                <div class="input-group" style="min-width: 350px;">
                    <input type="text" class="form-control" name="search" placeholder="Buscar mascota o dueño..." value="{{ $search ?? '' }}">
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="submit">
                            <i class="fas fa-search"></i>
                        </button>
                        @if(!empty($search))
                            <a href="{{ route('atender.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times"></i>
                            </a>
                        @endif
                    </div>
                </div>
            </form>
        </div>
        <div class="card-body">
            
            <div class="row">
                @forelse($duenos as $dueno)
                    <div class="col-md-12 mb-4">
                        <div class="card border-left-primary shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center mb-3">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                            Familia / Propietario
                                        </div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $dueno->nombre_completo }}</div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-users fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                                
                                <div class="table-responsive">
                                    <table class="table table-sm table-hover align-middle mb-0">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>Mascota</th>
                                                <th>Especie / Raza</th>
                                                <th>Edad</th>
                                                <th class="text-center">Acción</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($dueno->mascotas as $mascota)
                                            <tr>
                                                <td class="align-middle"><strong><i class="fas fa-paw text-info mr-1"></i> {{ $mascota->nombre }}</strong></td>
                                                <td class="align-middle">{{ $mascota->especie }} / {{ $mascota->raza }}</td>
                                                <td class="align-middle">{{ $mascota->edad ?? 'N/A' }}</td>
                                                <td class="text-center align-middle">
                                                    <a href="{{ route('expedientes.consultas.create', $mascota->id) }}" class="btn btn-sm btn-primary btn-icon-split">
                                                        <span class="icon text-white-50">
                                                            <i class="fas fa-stethoscope"></i>
                                                        </span>
                                                        <span class="text">Dar Consulta</span>
                                                    </a>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center text-muted my-5">
                        <i class="fas fa-box-open fa-3x mb-3"></i>
                        <p>No se encontraron pacientes activos con ese criterio de búsqueda.</p>
                    </div>
                @endforelse
            </div>

            <div class="d-flex justify-content-center mt-3">
                {{ $duenos->appends(['search' => $search ?? ''])->links() }}
            </div>
            
        </div>
    </div>

@endsection
