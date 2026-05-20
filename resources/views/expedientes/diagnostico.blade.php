@extends('layouts.app')

@section('titulo_pagina', 'Diagnóstico de la Consulta')

@section('contenido')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-stethoscope text-primary mr-2"></i>Diagnóstico: {{ $mascota->nombre }}
        </h1>
        <a href="{{ route('expedientes.consulta_detalle', ['mascota' => $mascota->id, 'consulta' => $consulta->id]) }}" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50"></i> Volver a Detalles
        </a>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Diagnóstico de la Consulta</h6>
                    <span class="badge badge-info px-3 py-2">
                        <i class="far fa-calendar-alt mr-1"></i> {{ \Carbon\Carbon::parse($consulta->fecha_consulta)->format('d/m/Y') }}
                    </span>
                </div>
                <div class="card-body">
                    
                    @if(empty($consulta->diagnostico))
                        <div class="alert alert-warning border-left-warning shadow-sm py-3" role="alert">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-exclamation-triangle fa-2x text-warning mr-3"></i>
                                <div>
                                    <h5 class="alert-heading font-weight-bold mb-1">Aún sin diagnóstico</h5>
                                    <p class="mb-0">No se ha registrado un diagnóstico para esta consulta médica. Por favor, ingrese uno a continuación.</p>
                                </div>
                            </div>
                        </div>
                    @endif

                    <form action="#" method="POST">
                        @csrf
                        <!-- Se asume que en un futuro se enviará a una ruta de actualización (ej. PUT/PATCH) -->
                        
                        <div class="form-group">
                            <label for="diagnostico" class="font-weight-bold text-gray-800">Descripción del Diagnóstico Médico</label>
                            <textarea class="form-control" id="diagnostico" name="diagnostico" rows="8" placeholder="Describa aquí los hallazgos y el diagnóstico...">{{ old('diagnostico', $consulta->diagnostico) }}</textarea>
                            <small class="form-text text-muted">
                                Ingrese todos los detalles clínicos observados durante la consulta.
                            </small>
                        </div>

                        <div class="text-right mt-4">
                            <button type="submit" class="btn btn-primary px-4 shadow-sm">
                                <i class="fas fa-save mr-1"></i> Guardar Diagnóstico
                            </button>
                        </div>
                    </form>
                    
                </div>
            </div>
        </div>
    </div>
@endsection
