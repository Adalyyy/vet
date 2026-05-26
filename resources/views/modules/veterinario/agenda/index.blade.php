@extends('layouts.app')

@section('titulo_pagina', 'Lista de Citas')

@section('contenido')

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">
        <i class="fas fa-list-alt text-primary mr-2"></i>Agenda y Prioridad de Citas
    </h1>
    <div>
        <a href="{{ route('citas.export_pdf') }}" class="btn btn-danger shadow-sm mr-2" target="_blank">
            <i class="fas fa-file-pdf fa-sm text-white-50 mr-2"></i> Exportar PDF
        </a>
        <button class="btn btn-primary shadow-sm" data-toggle="modal" data-target="#nuevaCitaModal">
            <i class="fas fa-plus fa-sm text-white-50 mr-2"></i> Agendar Nueva Cita
        </button>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success shadow-sm">
        <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
    </div>
@endif

@if($errors->any())
    <div class="alert alert-danger shadow-sm">
        <ul class="mb-0">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Próximas Citas e Historial</h6>
    </div>
    <div class="card-body">
        @if($citas->isEmpty())
            <p class="text-muted text-center mb-0 py-4">No hay citas agendadas actualmente.</p>
        @else
            <div class="table-responsive">
                <table class="table table-hover table-bordered align-middle">
                    <thead class="thead-light">
                        <tr>
                            <th width="15%">Fecha y Hora</th>
                            <th width="20%">Paciente / Invitado</th>
                            <th width="20%">Motivo</th>
                            <th width="15%">Veterinario</th>
                            <th width="10%" class="text-center">Estado</th>
                            <th width="20%" class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($citas as $cita)
                            @php
                                $isPast = $cita->fecha_hora->isPast() && $cita->estado == 'pendiente';
                                $rowClass = '';
                                if ($cita->estado == 'completada') $rowClass = 'bg-light text-muted';
                                if ($cita->estado == 'cancelada') $rowClass = 'bg-light text-muted';
                                if ($isPast) $rowClass = 'table-danger'; // Cita atrasada
                            @endphp
                            <tr class="{{ $rowClass }}">
                                <td>
                                    <strong>{{ $cita->fecha_hora->format('d/m/Y') }}</strong><br>
                                    <span class="text-info"><i class="far fa-clock"></i> {{ $cita->fecha_hora->format('H:i') }}</span>
                                    @if($isPast)
                                        <br><span class="badge badge-danger mt-1">Atrasada</span>
                                    @endif
                                </td>
                                <td>
                                    @if($cita->mascota_id)
                                        <strong><i class="fas fa-dog text-gray-500 mr-1"></i>{{ $cita->mascota->nombre }}</strong><br>
                                        <small class="text-muted">Dueño: {{ $cita->mascota->dueno->nombre_completo }}</small>
                                    @else
                                        <strong><i class="fas fa-user-tag text-gray-500 mr-1"></i>{{ $cita->nombre_invitado }}</strong><br>
                                        <small class="text-muted">Invitado</small>
                                    @endif
                                </td>
                                <td>{{ $cita->motivo }}</td>
                                <td>
                                    @if($cita->veterinario)
                                        <i class="fas fa-user-md text-gray-500 mr-1"></i>{{ $cita->veterinario->nombre_completo ?? $cita->veterinario->nombre }}
                                    @else
                                        <span class="text-muted font-italic">Sin asignar</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if($cita->estado == 'pendiente')
                                        <span class="badge badge-warning text-dark px-2 py-1"><i class="fas fa-hourglass-half mr-1"></i> Pendiente</span>
                                    @elseif($cita->estado == 'completada')
                                        <span class="badge badge-success px-2 py-1"><i class="fas fa-check mr-1"></i> Completada</span>
                                    @elseif($cita->estado == 'cancelada')
                                        <span class="badge badge-danger px-2 py-1"><i class="fas fa-times mr-1"></i> Cancelada</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center">
                                        <button class="btn btn-sm btn-info shadow-sm mr-1" data-toggle="modal" data-target="#verCitaModal{{ $cita->id }}" title="Ver Detalles">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        @if($cita->estado == 'pendiente')
                                            <form action="{{ route('citas.update', $cita->id) }}" method="POST" class="d-inline mr-1">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="estado" value="completada">
                                                <button type="submit" class="btn btn-sm btn-success shadow-sm" title="Marcar Completada" onclick="return confirm('¿Marcar esta cita como completada?');">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                            </form>
                                            <form action="{{ route('citas.update', $cita->id) }}" method="POST" class="d-inline mr-1">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="estado" value="cancelada">
                                                <button type="submit" class="btn btn-sm btn-warning shadow-sm text-dark" title="Cancelar Cita" onclick="return confirm('¿Desea cancelar esta cita?');">
                                                    <i class="fas fa-ban"></i>
                                                </button>
                                            </form>
                                        @endif
                                        <form action="{{ route('citas.destroy', $cita->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger shadow-sm" title="Eliminar Cita" onclick="return confirm('¿Está seguro de eliminar esta cita por completo?');">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>

                            <!-- Modal Detalles de Cita (Individual) -->
                            <div class="modal fade" id="verCitaModal{{ $cita->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content border-0 shadow">
                                        <div class="modal-header bg-info text-white">
                                            <h5 class="modal-title"><i class="fas fa-calendar-day mr-2"></i> Detalles de la Cita</h5>
                                            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body bg-light text-dark">
                                            <p><strong>Paciente / Invitado:</strong> 
                                                @if($cita->mascota_id)
                                                    {{ $cita->mascota->nombre }} (Mascota Registrada)
                                                @else
                                                    {{ $cita->nombre_invitado }} (Invitado)
                                                @endif
                                            </p>
                                            <p><strong>Motivo:</strong> {{ $cita->motivo }}</p>
                                            <p><strong>Fecha y Hora:</strong> {{ $cita->fecha_hora->format('d/m/Y H:i') }}</p>
                                            <p><strong>Veterinario Asignado:</strong> {{ $cita->veterinario ? ($cita->veterinario->nombre_completo ?? $cita->veterinario->nombre) : 'No asignado' }}</p>
                                            <p><strong>Estado:</strong> {{ strtoupper($cita->estado) }}</p>
                                            
                                            @if($cita->notas)
                                                <hr>
                                                <strong>Notas Adicionales:</strong>
                                                <div class="p-3 bg-white border rounded mt-2 text-muted">
                                                    {!! nl2br(e($cita->notas)) !!}
                                                </div>
                                            @endif
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>

<!-- Modal para Nueva Cita -->
<div class="modal fade" id="nuevaCitaModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content border-0 shadow">
            <form action="{{ route('citas.store') }}" method="POST">
                @csrf
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title"><i class="fas fa-calendar-plus mr-2"></i> Agendar Cita</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label class="font-weight-bold text-gray-700">Mascota Registrada</label>
                        <select name="mascota_id" class="form-control" id="selectMascota">
                            <option value="">-- No es cliente (Invitado) --</option>
                            @foreach($mascotas as $mascota)
                                <option value="{{ $mascota->id }}">{{ $mascota->nombre }} (Dueño: {{ $mascota->dueno->nombre_completo }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group" id="grupoInvitado">
                        <label class="font-weight-bold text-gray-700">Nombre del Invitado / Descripción</label>
                        <input type="text" name="nombre_invitado" class="form-control" placeholder="Ej. Juan Pérez - Perro desconocido">
                        <small class="text-muted">Llene esto solo si no seleccionó una mascota registrada.</small>
                    </div>
                    
                    <div class="form-group">
                        <label class="font-weight-bold text-gray-700">Veterinario Asignado</label>
                        <select name="veterinario_id" class="form-control">
                            <option value="">Sin asignar (Cualquiera)</option>
                            @foreach($veterinarios as $vet)
                                <option value="{{ $vet->id }}">{{ $vet->nombre_completo ?? $vet->nombre ?? 'Vet ' . $vet->id }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="font-weight-bold text-gray-700">Motivo de la Cita <span class="text-danger">*</span></label>
                        <input type="text" name="motivo" class="form-control" placeholder="Ej. Vacunación, Revisión, Estética..." required>
                    </div>

                    <div class="form-group">
                        <label class="font-weight-bold text-gray-700">Fecha y Hora <span class="text-danger">*</span></label>
                        @php
                            $minDate = now()->format('Y-m-d\TH:i');
                            // Limit 2 months ahead, but not crossing into next year
                            $maxDate = min(now()->addMonths(2), now()->endOfYear())->format('Y-m-d\TH:i');
                        @endphp
                        <input type="datetime-local" name="fecha_hora" class="form-control" required min="{{ $minDate }}" max="{{ $maxDate }}">
                        <small class="text-muted">Límite: Máximo 2 meses a partir de hoy (en este año).</small>
                    </div>

                    <div class="form-group">
                        <label class="font-weight-bold text-gray-700">Notas Adicionales</label>
                        <textarea name="notas" class="form-control" rows="2" placeholder="Información extra para la cita..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save mr-2"></i> Guardar Cita</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Controlar campo de invitado
        const selectMascota = document.getElementById('selectMascota');
        const grupoInvitado = document.getElementById('grupoInvitado');
        const inputInvitado = grupoInvitado.querySelector('input');

        selectMascota.addEventListener('change', function() {
            if (this.value !== "") {
                inputInvitado.value = "";
                inputInvitado.disabled = true;
                grupoInvitado.style.opacity = '0.5';
            } else {
                inputInvitado.disabled = false;
                grupoInvitado.style.opacity = '1';
            }
        });
    });
</script>
@endsection
