@extends('layouts.app')

@section('titulo_pagina', 'Dar Consulta - ' . $mascota->nombre)

@section('contenido')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">
        <i class="fas fa-stethoscope text-primary"></i> Nueva Consulta Médica
    </h1>
    <div>
        <a href="{{ route('atender.index') }}" class="btn btn-sm btn-secondary shadow-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50"></i> Volver al Directorio
        </a>
    </div>
</div>

@if($errors->any())
    <div class="alert alert-danger shadow-sm">
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
                    <button type="button" class="btn btn-outline-warning btn-sm btn-block mb-2" data-toggle="modal" data-target="#antecedentesModal">
                        <i class="fas fa-clipboard-list mr-1"></i> Revisar Antecedentes
                    </button>
                    <button type="button" class="btn btn-outline-info btn-sm btn-block" data-toggle="modal" data-target="#carnetModal">
                        <i class="fas fa-history mr-1"></i> Ver Carnet de Consultas
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Formulario de Consulta -->
    <div class="col-xl-8 col-lg-7">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-file-medical mr-2"></i>Registro de Evaluación Médica</h6>
                <span class="badge badge-primary">{{ \Carbon\Carbon::now()->format('d/m/Y h:i A') }}</span>
            </div>
            <div class="card-body">
                <form action="{{ route('expedientes.consultas.store', $mascota->id) }}" method="POST">
                    @csrf
                    
                    <h5 class="text-gray-800 font-weight-bold mb-3 border-bottom pb-2">Signos Vitales y Triaje</h5>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="font-weight-bold text-gray-700">Peso (kg)</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-weight"></i></span>
                                </div>
                                <input type="number" step="0.01" class="form-control" name="peso" placeholder="Ej. 12.5" value="{{ old('peso') }}">
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="font-weight-bold text-gray-700">Talla (cm)</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-ruler-vertical"></i></span>
                                </div>
                                <input type="number" step="0.01" class="form-control" name="talla" placeholder="Ej. 45" value="{{ old('talla') }}">
                            </div>
                        </div>
                    </div>

                    <h5 class="text-gray-800 font-weight-bold mt-4 mb-3 border-bottom pb-2">Evaluación Clínica</h5>
                    <div class="form-group">
                        <label class="font-weight-bold text-gray-700">Diagnóstico / Motivo de Consulta <span class="text-danger">*</span></label>
                        <textarea name="diagnostico" class="form-control" rows="4" placeholder="Describe los síntomas, hallazgos en la exploración física y el diagnóstico presuntivo o definitivo..." required>{{ old('diagnostico') }}</textarea>
                    </div>

                    <div class="form-group">
                        <label class="font-weight-bold text-gray-700">Tratamiento e Indicaciones Médicas</label>
                        <textarea name="tratamiento" class="form-control" rows="3" placeholder="Escribe las indicaciones generales, dieta, recomendaciones para casa...">{{ old('tratamiento') }}</textarea>
                    </div>

                    <div class="form-group">
                        <label class="font-weight-bold text-gray-700">Medicamentos Recetados (Receta)</label>
                        <textarea name="medicamentos" class="form-control" rows="3" placeholder="Ej. Amoxicilina 250mg - 1 tableta cada 8 hrs por 5 días...">{{ old('medicamentos') }}</textarea>
                    </div>

                    <div class="form-group border-top pt-3 mt-4">
                        <label class="font-weight-bold text-gray-700">Estado de la Consulta <span class="text-danger">*</span></label>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" id="estadoCerrada" name="estado" class="custom-control-input" value="cerrada" {{ old('estado', 'cerrada') == 'cerrada' ? 'checked' : '' }}>
                            <label class="custom-control-label font-weight-bold text-success" for="estadoCerrada"><i class="fas fa-check-circle"></i> Completada (Cerrada)</label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" id="estadoSeguimiento" name="estado" class="custom-control-input" value="en_seguimiento" {{ old('estado') == 'en_seguimiento' ? 'checked' : '' }}>
                            <label class="custom-control-label font-weight-bold text-warning" for="estadoSeguimiento"><i class="fas fa-clock"></i> En Seguimiento (Abierta)</label>
                        </div>
                        <small class="form-text text-muted mt-2">Selecciona "En Seguimiento" si el paciente debe regresar pronto para revisar esta misma afección.</small>
                    </div>

                    <div class="mt-4 text-right">
                        <button type="submit" class="btn btn-primary btn-lg shadow-sm">
                            <i class="fas fa-save mr-2"></i> Guardar Consulta
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Antecedentes Modal -->
<div class="modal fade" id="antecedentesModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content shadow border-0">
            <div class="modal-header bg-warning text-dark">
                <h5 class="modal-title font-weight-bold">
                    <i class="fas fa-clipboard-list mr-2"></i>Antecedentes Clínicos de {{ $mascota->nombre }}
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body bg-light">
                @if($mascota->antecedentes->isEmpty())
                    <div class="alert alert-info mb-0 text-center">
                        <i class="fas fa-info-circle mr-2"></i> No hay antecedentes registrados para este paciente.
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover mb-0 bg-white">
                            <thead class="thead-light">
                                <tr>
                                    <th width="25%">Categoría</th>
                                    <th>Descripción Detallada</th>
                                    <th width="25%">Detección</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($mascota->antecedentes as $antecedente)
                                    <tr>
                                        <td class="align-middle">
                                            @if($antecedente->tipo == 'alergia')
                                                <span class="badge badge-danger p-2"><i class="fas fa-exclamation-triangle"></i> Alergia</span>
                                            @elseif($antecedente->tipo == 'lesion')
                                                <span class="badge badge-warning text-dark p-2"><i class="fas fa-band-aid"></i> Lesión</span>
                                            @elseif($antecedente->tipo == 'patologia')
                                                <span class="badge badge-secondary p-2"><i class="fas fa-virus"></i> Patología</span>
                                            @elseif($antecedente->tipo == 'alimentacion')
                                                <span class="badge badge-success p-2"><i class="fas fa-bone"></i> Alimentación</span>
                                            @endif
                                        </td>
                                        <td class="align-middle text-gray-800">{{ $antecedente->descripcion }}</td>
                                        <td class="align-middle">
                                            {{ $antecedente->fecha_deteccion ? \Carbon\Carbon::parse($antecedente->fecha_deteccion)->format('d/m/Y') : 'N/A' }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
            <div class="modal-footer bg-white">
                <a href="{{ route('mascotas.antecedentes.index', $mascota->id) }}" class="btn btn-outline-primary" target="_blank">
                    <i class="fas fa-external-link-alt mr-1"></i> Ir a Gestión Completa
                </a>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<!-- Carnet de Consultas Modal -->
<div class="modal fade" id="carnetModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content shadow border-0">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title font-weight-bold">
                    <i class="fas fa-history mr-2"></i>Carnet de Consultas de {{ $mascota->nombre }}
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body bg-light">
                @if($mascota->consultas->isEmpty())
                    <div class="alert alert-info mb-0 text-center">
                        <i class="fas fa-info-circle mr-2"></i> No hay consultas previas para este paciente.
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover mb-0 bg-white">
                            <thead class="thead-light">
                                <tr>
                                    <th width="20%">Fecha</th>
                                    <th>Resumen de Diagnóstico</th>
                                    <th width="15%">Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($mascota->consultas as $consulta)
                                    <tr>
                                        <td class="align-middle">
                                            {{ \Carbon\Carbon::parse($consulta->fecha_consulta)->format('d/m/Y') }}<br>
                                            <small class="text-muted">{{ \Carbon\Carbon::parse($consulta->fecha_consulta)->format('H:i') }}</small>
                                        </td>
                                        <td class="align-middle text-gray-800">
                                            {{ Str::limit($consulta->diagnostico, 80, '...') }}
                                        </td>
                                        <td class="align-middle text-center">
                                            @if($consulta->estado == 'en_seguimiento')
                                                <span class="badge badge-warning text-dark px-2 py-1"><i class="fas fa-clock"></i> Abierta</span>
                                            @else
                                                <span class="badge badge-success px-2 py-1"><i class="fas fa-check"></i> Cerrada</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
            <div class="modal-footer bg-white">
                <a href="{{ route('mascotas.show', $mascota->id) }}" class="btn btn-outline-info" target="_blank">
                    <i class="fas fa-external-link-alt mr-1"></i> Ver Expediente Completo
                </a>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
@endsection
