@extends('layouts.app')

@section('titulo_pagina', 'Expedientes')

@section('contenido')
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Gestión de Expedientes</h6>
        </div>
        <div class="card-body">
            <!-- Buscador -->
            <div class="row justify-content-center mb-5 mt-3 position-relative">
                <div class="col-md-8">
                    <div class="shadow-sm rounded">
                        <input type="hidden" id="selectedMascotaId" value="">
                        <input type="text" id="searchInput" class="form-control form-control-lg border-0 bg-light rounded" placeholder="Buscar expediente por nombre de mascota o cliente..." aria-label="Buscar expediente" autocomplete="off">
                    </div>
                    
                    <!-- Contenedor de Resultados de Búsqueda -->
                    <div id="searchResults" class="list-group position-absolute w-100 shadow mt-1" style="z-index: 1000; display: none;">
                        <!-- Resultados inyectados por JS -->
                    </div>
                </div>
            </div>

            <!-- Botones de Acción -->
            <div class="row justify-content-center text-center mb-4">
                <div class="col-md-4 mb-3">
                    <button id="btnVerConsultas" class="btn btn-success btn-lg btn-block shadow-sm py-3" type="button">
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

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('searchInput');
        const searchResults = document.getElementById('searchResults');
        const btnVerConsultas = document.getElementById('btnVerConsultas');
        let timeout = null;

        searchInput.addEventListener('input', function() {
            clearTimeout(timeout);
            const query = this.value.trim();
            // Limpiar selección si borran el texto
            document.getElementById('selectedMascotaId').value = '';

            if (query.length === 0) {
                searchResults.style.display = 'none';
                searchResults.innerHTML = '';
                return;
            }

            timeout = setTimeout(() => {
                fetch(`{{ route('expedientes.search') }}?query=${encodeURIComponent(query)}`)
                    .then(response => response.json())
                    .then(data => {
                        searchResults.innerHTML = '';
                        if (data.length > 0) {
                            data.forEach(item => {
                                const a = document.createElement('a');
                                a.href = '#';
                                a.className = 'list-group-item list-group-item-action border-left-primary';
                                a.innerHTML = `
                                    <div class="d-flex w-100 justify-content-between">
                                      <h6 class="mb-1 text-primary font-weight-bold"><i class="fas fa-paw mr-1"></i> ${item.nombre} <small class="text-muted ml-2">(Folio #${item.id})</small></h6>
                                    </div>
                                    <p class="mb-1 small text-gray-800"><i class="fas fa-user mr-1 text-gray-400"></i> ${item.dueno_nombre} <span class="mx-2 text-gray-300">|</span> <i class="fas fa-tag mr-1 text-gray-400"></i> ${item.especie}</p>
                                `;
                                a.addEventListener('click', function(e) {
                                    e.preventDefault();
                                    document.getElementById('selectedMascotaId').value = item.id;
                                    searchInput.value = item.nombre + ' - ' + item.dueno_nombre;
                                    searchResults.style.display = 'none';
                                });
                                searchResults.appendChild(a);
                            });
                            searchResults.style.display = 'block';
                        } else {
                            searchResults.innerHTML = '<div class="list-group-item text-muted text-center py-3"><i class="fas fa-search-minus fa-2x mb-2 text-gray-300 d-block"></i> No se encontraron resultados.</div>';
                            searchResults.style.display = 'block';
                        }
                    })
                    .catch(error => console.error('Error:', error));
            }, 300); // 300ms debounce
        });

        // Ocultar resultados al hacer clic fuera del buscador
        document.addEventListener('click', function(e) {
            if (!searchInput.contains(e.target) && !searchResults.contains(e.target)) {
                searchResults.style.display = 'none';
            }
        });
        
        // Volver a mostrar si se hace clic en el input y hay texto
        searchInput.addEventListener('click', function() {
            if (this.value.trim().length > 0 && searchResults.innerHTML !== '') {
                searchResults.style.display = 'block';
            }
        });

        // Acción del botón Ver Consultas
        btnVerConsultas.addEventListener('click', function() {
            const mascotaId = document.getElementById('selectedMascotaId').value;
            if (mascotaId) {
                window.location.href = `/expedientes/${mascotaId}/consultas`;
            } else {
                // Usando SweetAlert o un alert simple
                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Atención',
                        text: 'Por favor, busque y seleccione una mascota primero.',
                        confirmButtonColor: '#4e73df'
                    });
                } else {
                    alert('Por favor, busque y seleccione una mascota primero.');
                }
            }
        });
    });
</script>
@endsection
