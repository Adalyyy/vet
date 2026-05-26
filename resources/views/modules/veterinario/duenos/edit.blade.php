@extends('layouts.app')

@section('titulo_pagina', 'Editar Dueño | Sistema Veterinaria')

@section('contenido')

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Editar Dueño: {{ $dueno->nombre_completo }}</h1>
        <a href="{{ route('duenos.index') }}" class="btn btn-sm btn-secondary shadow-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50"></i> Volver al listado
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Actualizar Información</h6>
        </div>
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger">
                    <strong>Error:</strong> Por favor corrige los siguientes errores:<br><br>
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('duenos.update', $dueno->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="nombre_completo" class="font-weight-bold">Nombre Completo <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('nombre_completo') is-invalid @enderror" id="nombre_completo" name="nombre_completo" value="{{ old('nombre_completo', $dueno->nombre_completo) }}" required>
                        @error('nombre_completo') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label for="telefono" class="font-weight-bold">Teléfono de Contacto <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('telefono') is-invalid @enderror" id="telefono" name="telefono" value="{{ old('telefono', $dueno->telefono) }}" required>
                        @error('telefono') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label for="direccion" class="font-weight-bold">Dirección Completa <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('direccion') is-invalid @enderror" id="direccion" name="direccion" rows="3" required>{{ old('direccion', $dueno->direccion) }}</textarea>
                        @error('direccion') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 mb-4">
                        <label for="redes_sociales" class="font-weight-bold">Redes Sociales / Notas Adicionales (Opcional)</label>
                        <input type="text" class="form-control @error('redes_sociales') is-invalid @enderror" id="redes_sociales" name="redes_sociales" value="{{ old('redes_sociales', $dueno->redes_sociales) }}" placeholder="Ej. Facebook: /juan.perez, Instagram: @juanp">
                        @error('redes_sociales') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                </div>

                <hr>
                
                <button type="submit" class="btn btn-warning"><i class="fas fa-edit"></i> Actualizar Dueño</button>
                <a href="{{ route('duenos.index') }}" class="btn btn-secondary">Cancelar</a>
            </form>
        </div>
    </div>

    <!-- Sección de Mascotas del Dueño -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-success"><i class="fas fa-paw"></i> Mascotas Registradas</h6>
            <button type="button" class="btn btn-sm btn-success shadow-sm" data-toggle="modal" data-target="#nuevaMascotaModal">
                <i class="fas fa-plus fa-sm text-white-50"></i> Agregar Nueva Mascota
            </button>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-sm" width="100%" cellspacing="0">
                    <thead class="thead-light">
                        <tr>
                            <th>Nombre</th>
                            <th>Especie / Raza</th>
                            <th>Fecha Nac.</th>
                            <th>¿Adoptado?</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($dueno->mascotas->where('activo', true) as $mascota)
                        <tr>
                            <td><strong>{{ $mascota->nombre }}</strong></td>
                            <td>{{ $mascota->especie }} / {{ $mascota->raza }}</td>
                            <td>{{ $mascota->fecha_nacimiento ?? 'N/A' }}</td>
                            <td>{{ $mascota->es_adoptado ? 'Sí' : 'No' }}</td>
                            <td>
                                <a href="{{ route('expedientes.consultas', $mascota->id) }}" class="btn btn-sm btn-info" title="Ver Expediente Médico"><i class="fas fa-folder-open"></i></a>
                                <button class="btn btn-sm btn-warning" data-toggle="modal" data-target="#editarMascotaModal{{ $mascota->id }}" title="Editar Mascota"><i class="fas fa-edit"></i></button>
                                <button class="btn btn-sm btn-danger" data-toggle="modal" data-target="#bajaMascotaModal{{ $mascota->id }}" title="Dar de Baja (Eliminar)"><i class="fas fa-trash"></i></button>
                            </td>
                        </tr>

                        <!-- Modal Editar Mascota -->
                        <div class="modal fade" id="editarMascotaModal{{ $mascota->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <form action="{{ route('duenos.mascotas.update', $mascota->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-header bg-warning text-dark">
                                            <h5 class="modal-title"><i class="fas fa-edit"></i> Editar Mascota: {{ $mascota->nombre }}</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body text-left">
                                            <div class="row">
                                                <div class="col-md-4 mb-3">
                                                    <label class="font-weight-bold">Nombre <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" name="nombre" value="{{ $mascota->nombre }}" required>
                                                </div>
                                                <div class="col-md-4 mb-3">
                                                    <label class="font-weight-bold">Especie <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" name="especie" value="{{ $mascota->especie }}" required>
                                                </div>
                                                <div class="col-md-4 mb-3">
                                                    <label class="font-weight-bold">Raza <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" name="raza" value="{{ $mascota->raza }}" required>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <label class="font-weight-bold">F. Nacimiento / Adopción <span class="text-danger">*</span></label>
                                                    <input type="date" class="form-control" name="fecha_nacimiento" value="{{ $mascota->fecha_nacimiento }}" required>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="font-weight-bold">Edad (Meses/Años)</label>
                                                    <input type="text" class="form-control" name="edad" value="{{ $mascota->edad }}" placeholder="Ej. 6 meses">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <label class="font-weight-bold">Tipo de Sangre</label>
                                                    <input type="text" class="form-control" name="tipo_sangre" value="{{ $mascota->tipo_sangre }}">
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="font-weight-bold">Comportamiento</label>
                                                    <input type="text" class="form-control" name="comportamiento" value="{{ $mascota->comportamiento }}">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input" id="es_adoptado_edit{{$mascota->id}}" name="es_adoptado" {{ $mascota->es_adoptado ? 'checked' : '' }}>
                                                        <label class="custom-control-label" for="es_adoptado_edit{{$mascota->id}}">¿Es adoptado?</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                            <button type="submit" class="btn btn-warning"><i class="fas fa-save"></i> Guardar Cambios</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Modal Baja / Eliminar Mascota -->
                        <div class="modal fade" id="bajaMascotaModal{{ $mascota->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content border-left-danger">
                                    <form action="{{ route('duenos.mascotas.baja', $mascota->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <div class="modal-header bg-danger text-white">
                                            <h5 class="modal-title"><i class="fas fa-exclamation-triangle"></i> Dar de Baja a {{ $mascota->nombre }}</h5>
                                            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body text-left">
                                            <p>Por favor seleccione el motivo por el cual esta mascota dejará de estar activa. <strong>Sus registros pasarán a solo lectura y no se eliminarán de la base de datos para preservar su historial clínico.</strong></p>
                                            
                                            <div class="form-group">
                                                <label class="font-weight-bold">Motivo de la baja <span class="text-danger">*</span></label>
                                                <select class="form-control" name="motivo" required onchange="if(this.value == 'Otro'){ document.getElementById('motivo_otro{{$mascota->id}}').style.display='block'; } else { document.getElementById('motivo_otro{{$mascota->id}}').style.display='none'; }">
                                                    <option value="">Seleccione un motivo...</option>
                                                    <option value="Adopción por un tercero">Fue dado en adopción / Cambio de dueño</option>
                                                    <option value="Fallecimiento">Fallecimiento</option>
                                                    <option value="Otro">Otro motivo</option>
                                                </select>
                                            </div>
                                            
                                            <div class="form-group" id="motivo_otro{{$mascota->id}}" style="display:none;">
                                                <label class="font-weight-bold">Especifique el motivo:</label>
                                                <input type="text" class="form-control" name="motivo_otro" placeholder="Escriba aquí los detalles...">
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                            <button type="submit" class="btn btn-danger"><i class="fas fa-archive"></i> Confirmar Baja</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted">Este dueño no tiene mascotas activas actualmente.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal Agregar Mascota -->
    <div class="modal fade" id="nuevaMascotaModal" tabindex="-1" role="dialog" aria-labelledby="nuevaMascotaModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <form action="{{ route('duenos.mascotas.store', $dueno->id) }}" method="POST">
                    @csrf
                    <div class="modal-header bg-success text-white">
                        <h5 class="modal-title" id="nuevaMascotaModalLabel"><i class="fas fa-plus"></i> Registrar Nueva Mascota para {{ $dueno->nombre_completo }}</h5>
                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="nombre" class="font-weight-bold">Nombre <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="nombre" name="nombre" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="especie" class="font-weight-bold">Especie <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="especie" name="especie" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="raza" class="font-weight-bold">Raza <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="raza" name="raza" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="fecha_nacimiento" class="font-weight-bold">F. Nacimiento / Adopción <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" id="fecha_nacimiento" name="fecha_nacimiento" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="edad" class="font-weight-bold">Edad (Meses/Años)</label>
                                <input type="text" class="form-control" id="edad" name="edad" placeholder="Ej. 6 meses, 3 años">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="tipo_sangre" class="font-weight-bold">Tipo de Sangre</label>
                                <input type="text" class="form-control" id="tipo_sangre" name="tipo_sangre">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="comportamiento" class="font-weight-bold">Comportamiento</label>
                                <input type="text" class="form-control" id="comportamiento" name="comportamiento">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="es_adoptado" name="es_adoptado">
                                    <label class="custom-control-label" for="es_adoptado">¿Es adoptado?</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Guardar Mascota</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
