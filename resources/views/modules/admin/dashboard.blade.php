@extends('layouts.admin')

@section('titulo_pagina', 'Dashboard | Panel de Administración')

@section('contenido')

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><i class="fas fa-user-shield"></i> Panel de Administración</h1>
        <span class="text-gray-600"><i class="fas fa-user-circle text-dark"></i> Bienvenido, {{ Auth::user()->name }}</span>
    </div>

    <!-- Content Row - Cards -->
    <div class="row">

        <!-- Veterinarios Registrados Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Veterinarios Registrados</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['veterinarios'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user-md fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Consultas Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Total Consultas Médicas</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['consultas'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-stethoscope fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Usuarios del Sistema Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Usuarios en el Sistema</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['usuarios'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Ingresos del Mes Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Pacientes Registrados</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['mascotas'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-paw fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Content Row - Recent Activity -->
    <div class="row mt-4">
        <!-- Últimos Pacientes -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Últimos Pacientes Registrados</h6>
                    <a href="{{ route('admin.mascotas.index') }}" class="btn btn-sm btn-primary shadow-sm"><i class="fas fa-arrow-right fa-sm"></i> Ver Todos</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-sm" width="100%" cellspacing="0">
                            <thead class="thead-light">
                                <tr>
                                    <th>Mascota</th>
                                    <th>Especie</th>
                                    <th>Dueño</th>
                                    <th>Registro</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($ultimasMascotas as $mascota)
                                <tr>
                                    <td><strong>{{ $mascota->nombre }}</strong></td>
                                    <td>{{ $mascota->especie }}</td>
                                    <td>{{ $mascota->dueno->nombre_completo ?? 'N/A' }}</td>
                                    <td>{{ $mascota->created_at->diffForHumans() }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted">Aún no hay pacientes registrados.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Últimas Consultas -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-success">Últimas Consultas Realizadas</h6>
                </div>
                <div class="card-body">
                    <div class="list-group">
                        @forelse($ultimasConsultas as $consulta)
                        <a href="{{ route('admin.mascotas.show', $consulta->mascota_id) }}" class="list-group-item list-group-item-action flex-column align-items-start">
                            <div class="d-flex w-100 justify-content-between">
                                <h6 class="mb-1 font-weight-bold"><i class="fas fa-stethoscope text-success"></i> Paciente: {{ $consulta->mascota->nombre ?? 'N/A' }}</h6>
                                <small class="text-muted">{{ \Carbon\Carbon::parse($consulta->fecha_consulta)->format('d/m/Y') }}</small>
                            </div>
                            <p class="mb-1 text-sm text-gray-800">
                                <strong>Atendió:</strong> {{ $consulta->veterinario->nombre_completo ?? 'N/A' }}<br>
                                <strong>Diagnóstico:</strong> {{ Str::limit($consulta->diagnostico, 60, '...') }}
                            </p>
                        </a>
                        @empty
                        <div class="text-center text-muted py-3">
                            Aún no se han registrado consultas en el sistema.
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
