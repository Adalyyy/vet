@extends('layouts.app')

@section('titulo_pagina', 'Gestión de Dueños | Sistema Veterinaria')

@section('contenido')

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><i class="fas fa-users"></i> Padrón de Dueños/Propietarios</h1>
        <a href="{{ route('duenos.create') }}" class="btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-plus fa-sm text-white-50"></i> Registrar Nuevo Dueño
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Directorio de Propietarios</h6>
            
            <form action="{{ route('duenos.index') }}" method="GET" class="form-inline">
                <div class="input-group input-group-sm">
                    <input type="text" class="form-control" name="search" placeholder="Buscar por nombre..." value="{{ $search ?? '' }}">
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="submit">
                            <i class="fas fa-search fa-sm"></i>
                        </button>
                        @if(!empty($search))
                            <a href="{{ route('duenos.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times fa-sm"></i>
                            </a>
                        @endif
                    </div>
                </div>
            </form>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped" width="100%" cellspacing="0">
                    <thead class="thead-light">
                        <tr>
                            <th>Nombre Completo</th>
                            <th>Teléfono</th>
                            <th>Dirección</th>
                            <th>Redes Sociales</th>
                            <th>Mascotas Reg.</th>
                            <th>Histórico</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($duenos as $dueno)
                        <tr>
                            <td><strong>{{ $dueno->nombre_completo }}</strong></td>
                            <td>{{ $dueno->telefono }}</td>
                            <td>{{ $dueno->direccion }}</td>
                            <td>{{ $dueno->redes_sociales ?? 'N/A' }}</td>
                            <td class="text-center">
                                <span class="badge badge-info">{{ $dueno->mascotas_count }}</span>
                            </td>
                            <td class="text-center">
                                <button class="btn btn-sm btn-secondary" data-toggle="modal" data-target="#historicoModal{{ $dueno->id }}" title="Ver Histórico Completo">
                                    <i class="fas fa-history"></i> Ver
                                </button>
                            </td>
                            <td>
                                <a href="{{ route('duenos.edit', $dueno->id) }}" class="btn btn-sm btn-warning btn-circle" title="Editar">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('duenos.destroy', $dueno->id) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Está seguro de eliminar a este propietario?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger btn-circle" title="Eliminar">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>

                        <!-- Modal Histórico -->
                        <div class="modal fade" id="historicoModal{{ $dueno->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header bg-secondary text-white">
                                        <h5 class="modal-title"><i class="fas fa-history"></i> Histórico Completo: {{ $dueno->nombre_completo }}</h5>
                                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <h6 class="font-weight-bold border-bottom pb-2 text-primary">Datos del Propietario (Solo Lectura)</h6>
                                        <div class="row mb-4">
                                            <div class="col-md-6"><strong>Nombre:</strong> {{ $dueno->nombre_completo }}</div>
                                            <div class="col-md-6"><strong>Teléfono:</strong> {{ $dueno->telefono }}</div>
                                            <div class="col-md-12 mt-2"><strong>Dirección:</strong> {{ $dueno->direccion }}</div>
                                            <div class="col-md-12 mt-2"><strong>Redes/Notas:</strong> {{ $dueno->redes_sociales ?? 'N/A' }}</div>
                                        </div>

                                        <h6 class="font-weight-bold border-bottom pb-2 text-success"><i class="fas fa-check-circle"></i> Mascotas Activas</h6>
                                        <ul class="list-group mb-4">
                                            @forelse ($dueno->mascotas->where('activo', true) as $mascota)
                                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                                    <div>
                                                        <strong>{{ $mascota->nombre }}</strong> ({{ $mascota->especie }} / {{ $mascota->raza }})
                                                    </div>
                                                    <span class="badge badge-success badge-pill">Activo</span>
                                                </li>
                                            @empty
                                                <li class="list-group-item text-muted">No tiene mascotas activas.</li>
                                            @endforelse
                                        </ul>

                                        <h6 class="font-weight-bold border-bottom pb-2 text-danger"><i class="fas fa-times-circle"></i> Mascotas Inactivas (Histórico)</h6>
                                        <ul class="list-group">
                                            @forelse ($dueno->mascotas->where('activo', false) as $mascota)
                                                <li class="list-group-item bg-light">
                                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                                        <strong>{{ $mascota->nombre }}</strong>
                                                        <span class="badge badge-danger badge-pill">Inactivo</span>
                                                    </div>
                                                    <div class="text-sm">
                                                        <span><strong>Especie/Raza:</strong> {{ $mascota->especie }} / {{ $mascota->raza }}</span><br>
                                                        <span><strong>Edad:</strong> {{ $mascota->edad ?? 'N/A' }}</span><br>
                                                        <span><strong>Ingreso:</strong> {{ $mascota->created_at->format('d/m/Y') }} | <strong>Baja:</strong> {{ $mascota->updated_at->format('d/m/Y') }}</span><br>
                                                        <span class="text-danger mt-1 d-block"><strong>Motivo de baja:</strong> {{ $mascota->motivo_baja }}</span>
                                                    </div>
                                                </li>
                                            @empty
                                                <li class="list-group-item text-muted">No tiene mascotas inactivas.</li>
                                            @endforelse
                                        </ul>
                                    </div>
                                    <div class="modal-footer d-flex justify-content-between">
                                        <form action="{{ route('duenos.pdf_historico', $dueno->id) }}" method="GET" target="_blank" class="d-inline-flex align-items-center">
                                            <div class="custom-control custom-checkbox mr-3">
                                                <input type="checkbox" class="custom-control-input" id="incluir_tratamientos{{$dueno->id}}" name="incluir_tratamientos" value="1">
                                                <label class="custom-control-label text-sm" for="incluir_tratamientos{{$dueno->id}}">Incluir tratamientos</label>
                                            </div>
                                            <button type="submit" class="btn btn-primary"><i class="fas fa-file-pdf"></i> Exportar a PDF</button>
                                        </form>
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @empty
                        <tr>
                            <td colspan="7" class="text-center">No hay propietarios registrados aún.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="d-flex justify-content-center mt-3">
                {{ $duenos->appends(['search' => $search ?? ''])->links() }}
            </div>
        </div>
    </div>

@endsection
