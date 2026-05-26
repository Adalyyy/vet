@extends('layouts.app')

@section('titulo_pagina', 'Antecedentes Clínicos - ' . $mascota->nombre)

@section('contenido')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">
        <i class="fas fa-clipboard-list text-primary"></i> Antecedentes Clínicos
    </h1>
    <div>
        <a href="{{ route('mascotas.show', $mascota->id) }}" class="btn btn-sm btn-info shadow-sm mr-2">
            <i class="fas fa-notes-medical fa-sm text-white-50"></i> Ver Expediente
        </a>
        <a href="{{ route('mascotas.index') }}" class="btn btn-sm btn-secondary shadow-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50"></i> Volver a Mascotas
        </a>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
        <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

@if($errors->any())
    <div class="alert alert-danger shadow-sm">
        <ul class="mb-0">
            @foreach($errors->all() as $error)
                <li><i class="fas fa-exclamation-circle mr-2"></i>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<!-- Tarjetas de Resumen del Paciente -->
<div class="row mb-4">
    <!-- Tarjeta Paciente -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Paciente</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $mascota->nombre }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-dog fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tarjeta Especie / Raza -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Especie / Raza</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $mascota->especie }} / {{ $mascota->raza }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-paw fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tarjeta Edad -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Edad</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $mascota->edad ?? 'No especificada' }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-birthday-cake fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tarjeta Dueño -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Propietario</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $mascota->dueno->nombre_completo ?? 'N/A' }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-user fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Tabla de Antecedentes -->
<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between bg-white">
        <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-list-alt mr-2"></i>Historial de Antecedentes Registrados</h6>
        <button class="btn btn-sm btn-primary shadow-sm" data-toggle="modal" data-target="#createAntecedenteModal">
            <i class="fas fa-plus-circle fa-sm text-white-50 mr-1"></i> Añadir Registro
        </button>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead class="thead-light">
                    <tr>
                        <th width="15%">Categoría</th>
                        <th width="50%">Descripción Detallada</th>
                        <th width="15%">Fecha de Detección</th>
                        <th width="20%" class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($antecedentes as $antecedente)
                    <tr>
                        <td class="align-middle text-center">
                            @if($antecedente->tipo == 'alergia')
                                <span class="badge badge-danger p-2" style="font-size: 13px; width: 100%;">
                                    <i class="fas fa-exclamation-triangle mr-1"></i> Alergia
                                </span>
                            @elseif($antecedente->tipo == 'lesion')
                                <span class="badge badge-warning p-2 text-dark" style="font-size: 13px; width: 100%;">
                                    <i class="fas fa-band-aid mr-1"></i> Lesión
                                </span>
                            @elseif($antecedente->tipo == 'patologia')
                                <span class="badge badge-secondary p-2" style="font-size: 13px; width: 100%;">
                                    <i class="fas fa-virus mr-1"></i> Patología
                                </span>
                            @elseif($antecedente->tipo == 'alimentacion')
                                <span class="badge badge-success p-2" style="font-size: 13px; width: 100%;">
                                    <i class="fas fa-bone mr-1"></i> Alimentación
                                </span>
                            @endif
                        </td>
                        <td class="align-middle">
                            <p class="mb-0 text-gray-800">{{ $antecedente->descripcion }}</p>
                        </td>
                        <td class="align-middle text-center">
                            @if($antecedente->fecha_deteccion)
                                <div class="text-gray-800 font-weight-bold">
                                    {{ \Carbon\Carbon::parse($antecedente->fecha_deteccion)->format('d/m/Y') }}
                                </div>
                                <div class="text-xs text-muted">
                                    {{ \Carbon\Carbon::parse($antecedente->fecha_deteccion)->diffForHumans() }}
                                </div>
                            @else
                                <span class="text-muted font-italic">No especificada</span>
                            @endif
                            @if($antecedente->archivos_medicos)
                                <div class="mt-2">
                                    <button class="btn btn-sm btn-outline-info shadow-sm" data-toggle="modal" data-target="#viewEvidenceModal{{$antecedente->id}}" title="Ver Archivo Adjunto">
                                        <i class="fas fa-paperclip"></i> Ver Evidencia
                                    </button>
                                </div>

                                <!-- View Evidence Modal -->
                                <div class="modal fade text-left" id="viewEvidenceModal{{$antecedente->id}}" tabindex="-1" role="dialog" aria-hidden="true">
                                    <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
                                        <div class="modal-content shadow border-0">
                                            <div class="modal-header bg-dark text-white">
                                                <h5 class="modal-title font-weight-bold">
                                                    <i class="fas fa-file-medical mr-2"></i>Evidencia Adjunta
                                                </h5>
                                                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body p-0 bg-light text-center" style="height: 75vh;">
                                                @php
                                                    $ext = pathinfo($antecedente->archivos_medicos, PATHINFO_EXTENSION);
                                                @endphp
                                                @if(in_array(strtolower($ext), ['jpg', 'jpeg', 'png', 'gif']))
                                                    <img src="{{ Storage::url($antecedente->archivos_medicos) }}" alt="Evidencia Médica" style="max-height: 100%; max-width: 100%; object-fit: contain;">
                                                @else
                                                    <iframe src="{{ Storage::url($antecedente->archivos_medicos) }}" width="100%" height="100%" style="border: none;"></iframe>
                                                @endif
                                            </div>
                                            <div class="modal-footer bg-white">
                                                <a href="{{ Storage::url($antecedente->archivos_medicos) }}" target="_blank" class="btn btn-outline-primary"><i class="fas fa-external-link-alt mr-1"></i> Abrir en otra pestaña</a>
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times mr-1"></i> Cerrar Visor</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </td>
                        <td class="align-middle text-center">
                            <button class="btn btn-sm btn-outline-primary" data-toggle="modal" data-target="#editAntecedenteModal{{ $antecedente->id }}" title="Editar Antecedente">
                                <i class="fas fa-edit"></i> Editar
                            </button>
                            <form action="{{ route('mascotas.antecedentes.destroy', [$mascota->id, $antecedente->id]) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Estás seguro de que deseas eliminar este antecedente de forma permanente?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Eliminar Antecedente">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        </td>
                    </tr>

                    <!-- Edit Modal -->
                    <div class="modal fade" id="editAntecedenteModal{{ $antecedente->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <form action="{{ route('mascotas.antecedentes.update', [$mascota->id, $antecedente->id]) }}" method="POST" class="w-100" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="modal-content border-0 shadow">
                                    <div class="modal-header bg-light">
                                        <h5 class="modal-title font-weight-bold text-primary">
                                            <i class="fas fa-edit mr-2"></i>Editar Antecedente
                                        </h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label class="font-weight-bold text-gray-700">Categoría del Antecedente</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-tag"></i></span>
                                                </div>
                                                <select name="tipo" class="form-control" required>
                                                    <option value="alergia" {{ $antecedente->tipo == 'alergia' ? 'selected' : '' }}>Alergia</option>
                                                    <option value="lesion" {{ $antecedente->tipo == 'lesion' ? 'selected' : '' }}>Lesión / Traumatismo</option>
                                                    <option value="patologia" {{ $antecedente->tipo == 'patologia' ? 'selected' : '' }}>Patología Previa</option>
                                                    <option value="alimentacion" {{ $antecedente->tipo == 'alimentacion' ? 'selected' : '' }}>Dietas / Alimentación</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="font-weight-bold text-gray-700">Descripción Detallada</label>
                                            <textarea name="descripcion" class="form-control" rows="4" placeholder="Describe los síntomas, tratamientos previos o detalles relevantes..." required>{{ $antecedente->descripcion }}</textarea>
                                        </div>
                                        <div class="form-group mb-0">
                                            <label class="font-weight-bold text-gray-700">Fecha de Detección (Opcional)</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                                </div>
                                                <input type="date" name="fecha_deteccion" class="form-control" value="{{ $antecedente->fecha_deteccion }}">
                                            </div>
                                            <small class="form-text text-muted">¿Aproximadamente cuándo se descubrió o inició esto?</small>
                                        </div>
                                        <div class="form-group mb-0 mt-3">
                                            <label class="font-weight-bold text-gray-700">Evidencia / Archivo Médico (Opcional)</label>
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" name="archivo" id="archivoEdit{{$antecedente->id}}" accept=".pdf,.jpg,.jpeg,.png,.doc,.docx">
                                                <label class="custom-file-label" for="archivoEdit{{$antecedente->id}}" data-browse="Buscar">Seleccionar archivo nuevo...</label>
                                            </div>
                                            <small class="form-text text-muted">Formatos: PDF, JPG, PNG, DOCX (Max: 5MB). Al subir uno nuevo, reemplazará al anterior.</small>
                                            @if($antecedente->archivos_medicos)
                                                <div class="mt-2 text-sm text-success">
                                                    <i class="fas fa-check-circle mr-1"></i> Archivo actual subido.
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="modal-footer bg-light">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                        <button type="submit" class="btn btn-primary"><i class="fas fa-save mr-1"></i> Guardar Cambios</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    @empty
                    <tr>
                        <td colspan="4">
                            <div class="text-center py-5">
                                <div class="mb-3">
                                    <i class="fas fa-clipboard-check fa-4x text-gray-300"></i>
                                </div>
                                <h5 class="text-gray-600 font-weight-bold">Paciente sin antecedentes</h5>
                                <p class="text-muted mb-4">Actualmente no hay alergias, lesiones, o patologías registradas para este paciente.</p>
                                <button class="btn btn-primary shadow-sm" data-toggle="modal" data-target="#createAntecedenteModal">
                                    <i class="fas fa-plus mr-1"></i> Registrar su primer antecedente
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Create Modal -->
<div class="modal fade" id="createAntecedenteModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <form action="{{ route('mascotas.antecedentes.store', $mascota->id) }}" method="POST" class="w-100" enctype="multipart/form-data">
            @csrf
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title font-weight-bold">
                        <i class="fas fa-plus-circle mr-2"></i>Registrar Nuevo Antecedente
                    </h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label class="font-weight-bold text-gray-700">Categoría del Antecedente</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-tag"></i></span>
                            </div>
                            <select name="tipo" class="form-control" required>
                                <option value="" disabled selected>Seleccione la categoría...</option>
                                <option value="alergia">Alergia</option>
                                <option value="lesion">Lesión / Traumatismo</option>
                                <option value="patologia">Patología Previa</option>
                                <option value="alimentacion">Dietas / Alimentación</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold text-gray-700">Descripción Detallada</label>
                        <textarea name="descripcion" class="form-control" rows="4" placeholder="Ej. Alérgico a la penicilina, fractura de fémur hace 2 años, dieta hipoalergénica..." required></textarea>
                    </div>
                    <div class="form-group mb-0">
                        <label class="font-weight-bold text-gray-700">Fecha de Detección (Opcional)</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                            </div>
                            <input type="date" name="fecha_deteccion" class="form-control">
                        </div>
                        <small class="form-text text-muted">¿Aproximadamente cuándo se descubrió o inició esto?</small>
                    </div>
                    <div class="form-group mb-0 mt-3">
                        <label class="font-weight-bold text-gray-700">Evidencia / Archivo Médico (Opcional)</label>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" name="archivo" id="archivoCreate" accept=".pdf,.jpg,.jpeg,.png,.doc,.docx">
                            <label class="custom-file-label" for="archivoCreate" data-browse="Buscar">Seleccionar archivo...</label>
                        </div>
                        <small class="form-text text-muted">Formatos: PDF, JPG, PNG, DOCX (Max: 5MB)</small>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save mr-1"></i> Guardar Registro</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
