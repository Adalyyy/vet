@extends('layouts.app')

@section('titulo_pagina', 'Consultas de ' . $mascota->nombre)

@section('contenido')
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Historial de Consultas: {{ $mascota->nombre }}</h6>
            <a href="{{ route('expedientes.index') }}" class="btn btn-sm btn-secondary shadow-sm">
                <i class="fas fa-arrow-left fa-sm text-white-50"></i> Volver a Expedientes
            </a>
        </div>
        <div class="card-body">
            <!-- Detalles de la mascota -->
            <div class="row mb-4">
                <div class="col-md-6">
                    <p><strong><i class="fas fa-paw mr-2 text-gray-500"></i> Nombre:</strong> {{ $mascota->nombre }}</p>
                    <p><strong><i class="fas fa-tag mr-2 text-gray-500"></i> Especie:</strong> {{ $mascota->especie }}</p>
                    <p><strong><i class="fas fa-barcode mr-2 text-gray-500"></i> Folio (ID):</strong> {{ $mascota->id }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong><i class="fas fa-user mr-2 text-gray-500"></i> Dueño:</strong> {{ $mascota->dueno ? $mascota->dueno->nombre_completo : 'Sin dueño' }}</p>
                    <p><strong><i class="fas fa-calendar-alt mr-2 text-gray-500"></i> Fecha de Nacimiento:</strong> {{ $mascota->fecha_nacimiento ?? 'No registrada' }}</p>
                </div>
            </div>

            <hr>

            <!-- Tabla de consultas -->
            <div class="table-responsive mt-4">
                @if($mascota->consultas && $mascota->consultas->count() > 0)
                    <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                        <thead class="thead-light">
                            <tr>
                                <th>Fecha</th>
                                <th>Peso (kg)</th>
                                <th>Talla (cm)</th>
                                <th class="text-center" style="width: 100px;">Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($mascota->consultas->sortByDesc('fecha_consulta') as $consulta)
                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($consulta->fecha_consulta)->format('d/m/Y H:i') }}</td>
                                    <td>{{ $consulta->peso ?? '-' }}</td>
                                    <td>{{ $consulta->talla ?? '-' }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('expedientes.consulta_detalle', ['mascota' => $mascota->id, 'consulta' => $consulta->id]) }}" class="btn btn-sm btn-primary shadow-sm" title="Ver Detalles">
                                            <i class="fas fa-eye"></i> Ver
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="alert alert-info text-center">
                        <i class="fas fa-info-circle mr-2"></i> No hay consultas registradas para este paciente.
                    </div>
                @endif
            </div>
            
            <div class="mt-4 text-center">
                <button class="btn btn-info btn-lg shadow-sm">
                    <i class="fas fa-plus fa-fw mr-2"></i> Nueva Consulta
                </button>
            </div>
        </div>
    </div>
@endsection
