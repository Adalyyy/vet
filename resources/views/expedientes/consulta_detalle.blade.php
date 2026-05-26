@extends('layouts.app')

@section('titulo_pagina', 'Detalles de Consulta Médica')

@section('contenido')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">
        <i class="fas fa-stethoscope text-primary mr-2"></i>Detalles de la Consulta Médica
    </h1>
    <div>
        <a href="{{ route('mascotas.show', $mascota->id) }}" class="btn btn-sm btn-secondary shadow-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50"></i> Volver al Expediente
        </a>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success shadow-sm mb-4">
        <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
    </div>
@endif
@if($errors->any())
    <div class="alert alert-danger shadow-sm mb-4">
        <ul class="mb-0">
            @foreach($errors->all() as $error)
                <li><i class="fas fa-exclamation-circle mr-2"></i>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="row">
    <!-- Información del Paciente -->
    <div class="col-xl-4 col-lg-5">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-paw mr-2"></i>Datos del Paciente</h6>
            </div>
            <div class="card-body">
                <div class="text-center mb-4">
                    <i class="fas fa-dog fa-4x text-gray-300"></i>
                    <h4 class="mt-3 font-weight-bold">{{ $mascota->nombre }}</h4>
                    <p class="text-muted mb-0">{{ $mascota->especie }} / {{ $mascota->raza }}</p>
                </div>
                <hr>
                <div class="row mb-2">
                    <div class="col-5 font-weight-bold text-gray-700">Edad:</div>
                    <div class="col-7">{{ $mascota->edad ?? 'No especificada' }}</div>
                </div>
                <div class="row mb-2">
                    <div class="col-5 font-weight-bold text-gray-700">Propietario:</div>
                    <div class="col-7">{{ $mascota->dueno->nombre_completo ?? 'N/A' }}</div>
                </div>
                <div class="row mb-2">
                    <div class="col-5 font-weight-bold text-gray-700">Teléfono:</div>
                    <div class="col-7">{{ $mascota->dueno->telefono ?? 'N/A' }}</div>
                </div>
                
                <div class="mt-4 text-center">
                    <a href="{{ route('mascotas.show', $mascota->id) }}" class="btn btn-outline-info btn-sm btn-block">
                        <i class="fas fa-external-link-alt mr-1"></i> Ver Expediente Completo
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Detalles y Seguimiento de Consulta -->
    <div class="col-xl-8 col-lg-7">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-file-medical mr-2"></i>Evaluación y Seguimiento</h6>
                <span class="badge badge-primary px-3 py-2"><i class="far fa-calendar-alt mr-1"></i> {{ \Carbon\Carbon::parse($consulta->fecha_consulta)->format('d/m/Y - H:i') }}</span>
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
                </div>

                <!-- Datos de la Consulta Pasada -->
                <div class="bg-gray-100 p-4 rounded border mb-4">
                    <h5 class="font-weight-bold text-gray-700 mb-4 border-bottom pb-2"><i class="fas fa-history mr-2 text-gray-500"></i>Registro Original de la Consulta</h5>
                    
                    <div class="mb-4">
                        <h6 class="font-weight-bold text-gray-600">Diagnóstico / Evaluación Clínica</h6>
                        <div class="p-3 bg-white border border-gray-300 rounded text-gray-600 font-italic">
                            {!! nl2br(e($consulta->diagnostico)) !!}
                        </div>
                    </div>

                    @if($consulta->tratamiento)
                        <div class="mb-4">
                            <h6 class="font-weight-bold text-gray-600">Tratamiento e Indicaciones</h6>
                            <div class="p-3 bg-white border border-gray-300 rounded text-gray-600 font-italic">
                                {!! nl2br(e($consulta->tratamiento)) !!}
                            </div>
                        </div>
                    @endif

                    @if($consulta->medicamentos)
                        <div class="mb-0">
                            <h6 class="font-weight-bold text-gray-600">Medicamentos (Receta)</h6>
                            <div class="p-3 bg-white border border-gray-300 rounded text-gray-600 font-italic">
                                {!! nl2br(e($consulta->medicamentos)) !!}
                            </div>
                        </div>
                    @endif
                </div>

                @if($consulta->estado == 'en_seguimiento')
                    <div class="card border-left-warning shadow-sm mt-5">
                        <div class="card-body">
                            <h5 class="text-warning font-weight-bold mb-3"><i class="fas fa-notes-medical mr-2"></i>Agregar Seguimiento a esta Consulta</h5>
                            <p class="text-muted small mb-4">Al guardar, esta información se añadirá al final del historial de esta consulta para darle continuidad.</p>
                            
                            <form action="{{ route('expedientes.consultas.update', ['mascota' => $mascota->id, 'consulta' => $consulta->id]) }}" method="POST">
                                @csrf
                                @method('PUT')
                                
                                <div class="form-group">
                                    <label class="font-weight-bold text-gray-800">Nuevo Diagnóstico / Notas de Seguimiento</label>
                                    <textarea name="diagnostico_nuevo" class="form-control text-dark" rows="3" placeholder="Describe la evolución del paciente..."></textarea>
                                </div>

                                <div class="form-group">
                                    <label class="font-weight-bold text-gray-800">Nuevo Tratamiento / Indicaciones Adicionales</label>
                                    <textarea name="tratamiento_nuevo" class="form-control text-dark" rows="2" placeholder="Nuevas recomendaciones (si aplica)..."></textarea>
                                </div>

                                <div class="form-group">
                                    <label class="font-weight-bold text-gray-800">Nuevos Medicamentos</label>
                                    <textarea name="medicamentos_nuevo" class="form-control text-dark" rows="2" placeholder="Medicamentos adicionales (si aplica)..."></textarea>
                                </div>

                                <div class="form-group border-top pt-3 mt-4 bg-light p-3 rounded">
                                    <label class="font-weight-bold text-gray-800 d-block mb-3">¿Cerrar Consulta o Mantener en Seguimiento?</label>
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
</div>
@endsection
