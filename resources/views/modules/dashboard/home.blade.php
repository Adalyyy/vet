@extends('layouts.app')

@section('titulo_pagina', 'Dashboard | Sistema Veterinaria')

@section('contenido')

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><i class="fas fa-paw text-primary mr-2"></i> Dashboard Principal</h1>
        <a href="{{ route('atender.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-notes-medical fa-sm text-white-50 mr-2"></i> Atender Mascota
        </a>
    </div>

    <!-- Content Row - Cards -->
    <div class="row">

        <!-- Pacientes Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Pacientes Activos</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['pacientes'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-dog fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Consultas Hoy Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Consultas (Hoy)</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['consultas_hoy'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-stethoscope fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Propietarios Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Propietarios Registrados</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['propietarios'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Citas Pendientes Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Citas Pendientes</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['citas_pendientes'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar-check fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Content Row - Tablas -->
    <div class="row">
        <!-- Próximas Citas -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow mb-4 h-100">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-warning"><i class="fas fa-calendar-alt mr-2"></i> Próximas Citas Agendadas</h6>
                    <a href="{{ route('citas.index') }}" class="btn btn-sm btn-outline-warning text-dark shadow-sm">Ver Todas</a>
                </div>
                <div class="card-body">
                    @if($proximasCitas->isEmpty())
                        <div class="text-center py-4">
                            <i class="fas fa-calendar-times fa-3x text-gray-300 mb-3"></i>
                            <p class="text-muted">No hay citas pendientes próximas.</p>
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-sm table-hover align-middle">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Fecha / Hora</th>
                                        <th>Paciente</th>
                                        <th>Motivo</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($proximasCitas as $cita)
                                        <tr>
                                            <td>
                                                <span class="font-weight-bold text-gray-800">{{ $cita->fecha_hora->format('d/m/Y') }}</span><br>
                                                <small class="text-info"><i class="far fa-clock"></i> {{ $cita->fecha_hora->format('H:i') }}</small>
                                            </td>
                                            <td>
                                                @if($cita->mascota_id)
                                                    <a href="{{ route('mascotas.show', $cita->mascota_id) }}" class="font-weight-bold text-primary">{{ $cita->mascota->nombre }}</a>
                                                @else
                                                    <span class="font-weight-bold text-secondary">{{ $cita->nombre_invitado }}</span> <span class="badge badge-secondary badge-sm">Invitado</span>
                                                @endif
                                            </td>
                                            <td>{{ $cita->motivo }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Últimas Consultas -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow mb-4 h-100">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-success"><i class="fas fa-stethoscope mr-2"></i> Últimas Consultas Atendidas</h6>
                    <a href="{{ route('atender.index') }}" class="btn btn-sm btn-outline-success shadow-sm">Directorio</a>
                </div>
                <div class="card-body">
                    @if($consultasRecientes->isEmpty())
                        <div class="text-center py-4">
                            <i class="fas fa-file-medical-alt fa-3x text-gray-300 mb-3"></i>
                            <p class="text-muted">Aún no se han registrado consultas.</p>
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-sm table-hover align-middle">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Fecha</th>
                                        <th>Mascota</th>
                                        <th>Estado</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($consultasRecientes as $consulta)
                                        <tr>
                                            <td>
                                                <span class="font-weight-bold text-gray-800">{{ \Carbon\Carbon::parse($consulta->fecha_consulta)->format('d/m/Y') }}</span>
                                            </td>
                                            <td>
                                                <a href="{{ route('mascotas.show', $consulta->mascota_id) }}" class="font-weight-bold text-primary">{{ $consulta->mascota->nombre }}</a><br>
                                                <small class="text-muted">{{ Str::limit($consulta->diagnostico, 35) }}</small>
                                            </td>
                                            <td>
                                                @if($consulta->estado == 'en_seguimiento')
                                                    <span class="badge badge-warning text-dark"><i class="fas fa-clock"></i> Seguimiento</span>
                                                @else
                                                    <span class="badge badge-success"><i class="fas fa-check"></i> Cerrada</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

@endsection
