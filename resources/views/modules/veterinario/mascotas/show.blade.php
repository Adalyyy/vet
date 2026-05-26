@extends('layouts.app')

@section('titulo_pagina', 'Historial Clínico Resumido')

@section('contenido')

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><i class="fas fa-notes-medical"></i> Historial Clínico: {{ $mascota->nombre }}</h1>
        <div>
            <a href="{{ route('mascotas.pdf_historial', $mascota->id) }}" class="btn btn-sm btn-danger shadow-sm mr-2">
                <i class="fas fa-file-pdf fa-sm text-white-50"></i> Exportar Historial en PDF
            </a>
            <a href="{{ route('mascotas.index') }}" class="btn btn-sm btn-secondary shadow-sm">
                <i class="fas fa-arrow-left fa-sm text-white-50"></i> Volver al listado
            </a>
        </div>
    </div>

    <div class="row">
        <!-- Detalles de la mascota -->
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Descripción de la Mascota</div>
                            <div class="h6 mb-0 font-weight-bold text-gray-800">Nombre: {{ $mascota->nombre }}</div>
                            <div class="mt-2 text-gray-600 small">
                                <strong>Especie:</strong> {{ $mascota->especie }}<br>
                                <strong>Raza:</strong> {{ $mascota->raza }}<br>
                                <strong>Fecha de Nacimiento:</strong> {{ $mascota->fecha_nacimiento ?? 'Desconocida' }}<br>
                                <strong>Tipo de Sangre:</strong> {{ $mascota->tipo_sangre ?? 'N/A' }}<br>
                                <strong>Comportamiento:</strong> {{ $mascota->comportamiento ?? 'N/A' }}<br>
                                <strong>¿Adoptado?:</strong> {{ $mascota->es_adoptado ? 'Sí' : 'No' }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-paw fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Veterinarios involucrados -->
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Veterinarios que lo atendieron</div>
                            <div class="mt-2 text-gray-600">
                                @if($veterinariosAtendieron->isEmpty())
                                    <span class="small">Ningún veterinario ha atendido a esta mascota aún.</span>
                                @else
                                    <ul class="pl-3 mb-0 small">
                                        @foreach($veterinariosAtendieron as $vet_nombre)
                                            <li>{{ $vet_nombre }}</li>
                                        @endforeach
                                    </ul>
                                @endif
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user-md fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Información del Dueño -->
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Datos del Dueño</div>
                            <div class="h6 mb-0 font-weight-bold text-gray-800">{{ $mascota->dueno->nombre_completo }}</div>
                            <div class="mt-2 text-gray-600 small">
                                <strong>Teléfono:</strong> {{ $mascota->dueno->telefono ?? 'N/A' }}<br>
                                <strong>Dirección:</strong> {{ $mascota->dueno->direccion ?? 'N/A' }}<br>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Historial de tratamientos resumido -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Historial de Tratamientos (Resumido)</h6>
        </div>
        <div class="card-body">
            @if($mascota->consultas->isEmpty())
                <p class="text-muted">No existen registros de consultas médicas o tratamientos para esta mascota.</p>
            @else
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" width="100%" cellspacing="0">
                        <thead class="thead-light">
                            <tr>
                                <th width="12%">Fecha</th>
                                <th width="18%">Veterinario</th>
                                <th width="10%">Peso</th>
                                <th width="10%">Talla</th>
                                <th width="20%">Diagnóstico (Resumen)</th>
                                <th width="20%">Tratamiento Indicado</th>
                                <th width="10%">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($mascota->consultas->sortByDesc('fecha_consulta') as $consulta)
                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($consulta->fecha_consulta)->format('d/m/Y') }}</td>
                                    <td>{{ $consulta->veterinario->nombre_completo ?? 'N/A' }}</td>
                                    <td>{{ $consulta->peso ? $consulta->peso . ' kg' : 'N/A' }}</td>
                                    <td>{{ $consulta->talla ? $consulta->talla . ' cm' : 'N/A' }}</td>
                                    <td>{{ Str::limit($consulta->diagnostico, 100, '...') }}</td>
                                    <td>{{ Str::limit($consulta->tratamiento, 150, '...') }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('mascotas.pdf_consulta', $consulta->id) }}" class="btn btn-sm btn-outline-danger" title="Descargar Consulta en PDF">
                                            <i class="fas fa-file-pdf"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>

@endsection
