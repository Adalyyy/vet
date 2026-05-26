@extends('layouts.app')

@section('titulo_pagina', 'Detalle de Consulta')

@section('contenido')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-stethoscope text-primary mr-2"></i>Consulta: {{ $mascota->nombre }}
        </h1>
        <a href="{{ route('mascotas.show', $mascota->id) }}" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50"></i> Volver al Expediente
        </a>
    </div>

    <div class="row">
        <!-- Detalles de la Consulta -->
        <div class="col-lg-8 mb-4">
            <div class="card shadow mb-4 h-100">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Detalles de la Consulta Médica</h6>
                    <span class="badge badge-info px-3 py-2">
                        <i class="far fa-calendar-alt mr-1"></i> {{ \Carbon\Carbon::parse($consulta->fecha_consulta)->format('d/m/Y - H:i') }}
                    </span>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6 mb-3">
                            <div class="p-3 bg-light rounded border-left-success h-100">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Veterinario Atendió</div>
                                <div class="h6 mb-0 font-weight-bold text-gray-800">
                                    <i class="fas fa-user-md mr-2"></i>{{ $consulta->veterinario ? $consulta->veterinario->nombre : 'No especificado' }}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="p-3 bg-light rounded border-left-info h-100">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Peso</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $consulta->peso ?? '--' }} <small>kg</small></div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="p-3 bg-light rounded border-left-warning h-100">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Talla</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $consulta->talla ?? '--' }} <small>cm</small></div>
                            </div>
                    </div>

                    <!-- Datos de la Consulta Pasada -->
                    <div class="mb-4">
                        <h6 class="font-weight-bold text-gray-800 border-bottom pb-2">Diagnóstico / Evaluación Clínica</h6>
                        <div class="p-3 bg-white border rounded text-dark">
                            {!! nl2br(e($consulta->diagnostico)) !!}
                        </div>
                    </div>

                    @if($consulta->tratamiento)
                        <div class="mb-4">
                            <h6 class="font-weight-bold text-gray-800 border-bottom pb-2">Tratamiento e Indicaciones</h6>
                            <div class="p-3 bg-white border rounded text-dark">
                                {!! nl2br(e($consulta->tratamiento)) !!}
                            </div>
                        </div>
                    @endif

                    @if($consulta->medicamentos)
                        <div class="mb-4">
                            <h6 class="font-weight-bold text-gray-800 border-bottom pb-2">Medicamentos (Receta)</h6>
                            <div class="p-3 bg-white border rounded text-dark">
                                {!! nl2br(e($consulta->medicamentos)) !!}
                            </div>
                        </div>
                    @endif

                    @if(session('success'))
                        <div class="alert alert-success mt-3 shadow-sm">
                            <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
                        </div>
                    @endif

                    @if($consulta->estado == 'en_seguimiento')
                        <div class="mt-5 border-top pt-4">
                            <h5 class="text-warning font-weight-bold mb-3"><i class="fas fa-notes-medical mr-2 text-warning"></i>Agregar Seguimiento a esta Consulta</h5>
                            <p class="text-muted small">Al guardar, esta información se añadirá al final del historial de esta consulta para darle continuidad.</p>
                            
                            @if($errors->any())
                                <div class="alert alert-danger shadow-sm">
                                    <ul class="mb-0">
                                        @foreach($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            
                            <form action="{{ route('expedientes.consultas.update', ['mascota' => $mascota->id, 'consulta' => $consulta->id]) }}" method="POST">
                                @csrf
                                @method('PUT')
                                
                                <div class="form-group">
                                    <label class="font-weight-bold text-gray-700">Nuevo Diagnóstico / Notas de Seguimiento</label>
                                    <textarea name="diagnostico_nuevo" class="form-control" rows="3" placeholder="Describe la evolución del paciente..."></textarea>
                                </div>

                                <div class="form-group">
                                    <label class="font-weight-bold text-gray-700">Nuevo Tratamiento / Indicaciones Adicionales</label>
                                    <textarea name="tratamiento_nuevo" class="form-control" rows="2" placeholder="Nuevas recomendaciones (si aplica)..."></textarea>
                                </div>

                                <div class="form-group">
                                    <label class="font-weight-bold text-gray-700">Nuevos Medicamentos</label>
                                    <textarea name="medicamentos_nuevo" class="form-control" rows="2" placeholder="Medicamentos adicionales (si aplica)..."></textarea>
                                </div>

                                <div class="form-group border-top pt-3 mt-4 bg-light p-3 rounded">
                                    <label class="font-weight-bold text-gray-700 d-block mb-3">¿Cerrar Consulta o Mantener en Seguimiento?</label>
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" id="estadoCerrada" name="estado" class="custom-control-input" value="cerrada">
                                        <label class="custom-control-label font-weight-bold text-success" for="estadoCerrada"><i class="fas fa-check-circle"></i> Completar y Cerrar Consulta</label>
                                    </div>
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" id="estadoSeguimiento" name="estado" class="custom-control-input" value="en_seguimiento" checked>
                                        <label class="custom-control-label font-weight-bold text-warning" for="estadoSeguimiento"><i class="fas fa-clock"></i> Mantener en Seguimiento</label>
                                    </div>
                                </div>

                                <div class="mt-4 text-right">
                                    <button type="submit" class="btn btn-warning btn-lg shadow-sm font-weight-bold text-dark">
                                        <i class="fas fa-save mr-2"></i> Guardar Seguimiento
                                    </button>
                                </div>
                            </form>
                        </div>
                    @else
                        <div class="mt-4 alert alert-success text-center shadow-sm">
                            <i class="fas fa-check-circle fa-2x mb-2 d-block"></i>
                            <strong>Esta consulta ha sido cerrada y archivada de manera definitiva.</strong>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Antecedentes del Paciente -->
        <div class="col-lg-4 mb-4">
            <div class="card shadow mb-4 h-100">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Antecedentes Clínicos</h6>
                </div>
                <div class="card-body">
                    <div class="text-center mb-4">
                        <div class="bg-gray-200 rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                            <i class="fas fa-paw fa-3x text-gray-500"></i>
                        </div>
                        <h5 class="mt-3 font-weight-bold">{{ $mascota->nombre }}</h5>
                        <p class="text-muted small mb-0">{{ $mascota->especie }} | {{ $mascota->raza ?? 'Raza no especificada' }}</p>
                    </div>

                    <ul class="list-group list-group-flush">
                        <li class="list-group-item px-0 d-flex justify-content-between align-items-center">
                            <span class="text-gray-600">Tipo de Sangre:</span>
                            <span class="font-weight-bold text-danger">{{ $mascota->tipo_sangre ?? 'Desconocido' }}</span>
                        </li>
                        <li class="list-group-item px-0">
                            <span class="text-gray-600 d-block mb-1">Comportamiento:</span>
                            <span class="font-weight-bold text-gray-800">{{ $mascota->comportamiento ?? 'No especificado' }}</span>
                        </li>
                        <li class="list-group-item px-0 d-flex justify-content-between align-items-center">
                            <span class="text-gray-600">¿Es Adoptado?:</span>
                            @if(isset($mascota->es_adoptado) && $mascota->es_adoptado)
                                <span class="badge badge-success px-2 py-1"><i class="fas fa-check mr-1"></i> Sí</span>
                            @else
                                <span class="badge badge-secondary px-2 py-1"><i class="fas fa-times mr-1"></i> No / Desconocido</span>
                            @endif
                        </li>
                        <li class="list-group-item px-0">
                            <span class="text-gray-600 d-block mb-1">Dueño:</span>
                            <span class="font-weight-bold text-primary">
                                <i class="fas fa-user mr-1"></i> {{ $mascota->dueno ? $mascota->dueno->nombre_completo : 'Sin asignar' }}
                            </span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
