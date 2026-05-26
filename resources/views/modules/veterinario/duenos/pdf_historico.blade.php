<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Histórico de Propietario - {{ $dueno->nombre_completo }}</title>
    <style>
        body { font-family: 'Helvetica', 'Arial', sans-serif; font-size: 12px; color: #333; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #2c3e50; padding-bottom: 10px; }
        .title { font-size: 18px; font-weight: bold; color: #2c3e50; margin: 0; }
        .subtitle { font-size: 14px; color: #7f8c8d; margin-top: 5px; }
        .section-title { font-size: 14px; background-color: #ecf0f1; padding: 5px; border-left: 4px solid #2980b9; margin-top: 20px; margin-bottom: 10px; font-weight: bold; }
        .info-table { width: 100%; border-collapse: collapse; margin-bottom: 10px; }
        .info-table td { padding: 5px; border-bottom: 1px solid #ddd; }
        .info-table td:first-child { font-weight: bold; width: 25%; color: #2c3e50; }
        
        .mascota-card { border: 1px solid #bdc3c7; border-radius: 4px; padding: 10px; margin-bottom: 15px; }
        .mascota-header { font-weight: bold; font-size: 14px; margin-bottom: 5px; color: #2c3e50; border-bottom: 1px solid #ecf0f1; padding-bottom: 5px;}
        .mascota-baja { background-color: #fde8e8; border-color: #e74c3c; }
        .mascota-baja .mascota-header { color: #c0392b; }
        
        .consultas-table { width: 100%; border-collapse: collapse; margin-top: 10px; font-size: 11px;}
        .consultas-table th, .consultas-table td { border: 1px solid #ddd; padding: 4px; text-align: left; }
        .consultas-table th { background-color: #f2f2f2; color: #333; }
    </style>
</head>
<body>

    <div class="header">
        <h1 class="title">REPORTE HISTÓRICO DE PROPIETARIO</h1>
        <p class="subtitle">Generado el {{ date('d/m/Y H:i') }}</p>
    </div>

    <div class="section-title">DATOS DEL PROPIETARIO</div>
    <table class="info-table">
        <tr>
            <td>Nombre Completo:</td>
            <td>{{ $dueno->nombre_completo }}</td>
        </tr>
        <tr>
            <td>Teléfono:</td>
            <td>{{ $dueno->telefono }}</td>
        </tr>
        <tr>
            <td>Dirección:</td>
            <td>{{ $dueno->direccion }}</td>
        </tr>
        <tr>
            <td>Redes Sociales / Notas:</td>
            <td>{{ $dueno->redes_sociales ?? 'No especificado' }}</td>
        </tr>
    </table>

    <div class="section-title">MASCOTAS ACTIVAS</div>
    @php
        $activas = $dueno->mascotas->where('activo', true);
    @endphp
    @if($activas->count() > 0)
        @foreach($activas as $mascota)
            <div class="mascota-card">
                <div class="mascota-header">
                    🐾 {{ $mascota->nombre }} ({{ $mascota->especie }} - {{ $mascota->raza }})
                </div>
                <table style="width: 100%; font-size: 11px;">
                    <tr>
                        <td><strong>F. Nacimiento:</strong> {{ $mascota->fecha_nacimiento ?? 'N/A' }}</td>
                        <td><strong>Edad:</strong> {{ $mascota->edad ?? 'N/A' }}</td>
                        <td><strong>Ingreso:</strong> {{ $mascota->created_at->format('d/m/Y') }}</td>
                    </tr>
                </table>

                @if($mascota->consultas->count() > 0)
                    <table class="consultas-table">
                        <thead>
                            <tr>
                                <th style="width: 15%">Fecha</th>
                                <th style="width: {{ $incluirTratamientos ? '30%' : '85%' }}">Diagnóstico</th>
                                @if($incluirTratamientos)
                                <th style="width: 55%">Tratamiento Indicado</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($mascota->consultas as $consulta)
                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($consulta->fecha_consulta)->format('d/m/Y') }}</td>
                                    <td>{{ $consulta->diagnostico }}</td>
                                    @if($incluirTratamientos)
                                    <td>{{ $consulta->tratamiento }}</td>
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p style="font-size: 11px; margin-top: 5px; color: #7f8c8d;">No hay historial de consultas registrado.</p>
                @endif
            </div>
        @endforeach
    @else
        <p>No se encontraron mascotas activas.</p>
    @endif

    <div class="section-title" style="border-left-color: #e74c3c;">HISTÓRICO (MASCOTAS INACTIVAS / BAJAS)</div>
    @php
        $inactivas = $dueno->mascotas->where('activo', false);
    @endphp
    @if($inactivas->count() > 0)
        @foreach($inactivas as $mascota)
            <div class="mascota-card mascota-baja">
                <div class="mascota-header">
                    ❌ {{ $mascota->nombre }} ({{ $mascota->especie }} - {{ $mascota->raza }})
                </div>
                <table style="width: 100%; font-size: 11px; margin-bottom: 5px;">
                    <tr>
                        <td><strong>Edad:</strong> {{ $mascota->edad ?? 'N/A' }}</td>
                        <td><strong>Ingreso:</strong> {{ $mascota->created_at->format('d/m/Y') }}</td>
                        <td><strong>Fecha Baja:</strong> {{ $mascota->updated_at->format('d/m/Y') }}</td>
                    </tr>
                </table>
                <div style="font-size: 12px; color: #c0392b; margin-top: 5px;">
                    <strong>Motivo de Baja:</strong> {{ $mascota->motivo_baja }}
                </div>
                @if($mascota->motivo_baja === 'Fallecimiento')
                <div style="font-size: 11px; font-style: italic; color: #7f8c8d; margin-top: 6px; padding: 5px; background-color: #fff; border-radius: 3px;">
                    "El amor incondicional que nos dan deja una huella imborrable en nuestros corazones. En memoria de un gran amigo fiel."
                </div>
                @endif
            </div>
        @endforeach
    @else
        <p>No hay registro de bajas.</p>
    @endif

</body>
</html>
