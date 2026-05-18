@extends('layouts.app')

@section('titulo_pagina', 'Expedientes')

@section('contenido')
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Gestión de Expedientes</h6>
        </div>
        <div class="card-body">
            <!-- Buscador -->
            <div class="row justify-content-center mb-5 mt-3">
                <div class="col-md-8">
                    <div class="input-group input-group-lg shadow-sm rounded">
                        <input type="text" class="form-control border-0 bg-light" placeholder="Buscar expediente por nombre de mascota o cliente..." aria-label="Buscar expediente" aria-describedby="basic-addon2">
                        <div class="input-group-append">
                            <button class="btn btn-primary px-4" type="button">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Botones de Acción -->
            <div class="row justify-content-center text-center mb-4">
                <div class="col-md-4 mb-3">
                    <button class="btn btn-success btn-lg btn-block shadow-sm py-3" type="button">
                        <i class="fas fa-stethoscope fa-fw mr-2"></i> Ver Consultas
                    </button>
                </div>
                <div class="col-md-4 mb-3">
                    <button class="btn btn-info btn-lg btn-block shadow-sm py-3" type="button">
                        <i class="fas fa-plus fa-fw mr-2"></i> Nuevo Paciente / Mascota
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection
