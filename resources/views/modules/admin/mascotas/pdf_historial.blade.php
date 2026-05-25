<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Historial Clínico - {{ $mascota->nombre }}</title>
    <style>
        body { font-family: Helvetica, Arial, sans-serif; font-size: 12px; color: #333; }
        .header { text-align: center; margin-bottom: 30px; border-bottom: 2px solid #4e73df; padding-bottom: 10px; }
        .header h1 { margin: 0; color: #4e73df; font-size: 24px; }
        .header p { margin: 5px 0 0 0; color: #666; }
        
        .box-container { width: 100%; margin-bottom: 20px; }
        .box { width: 48%; display: inline-block; vertical-align: top; }
        
        .section-title { font-size: 14px; font-weight: bold; background-color: #eaecf4; color: #4e73df; padding: 5px 10px; margin-bottom: 10px; }
        
        .data-list { list-style: none; padding: 0; margin: 0; }
        .data-list li { margin-bottom: 5px; }
        .data-list strong { display: inline-block; width: 120px; }
        
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #d1d3e2; padding: 8px; text-align: left; vertical-align: top; }
        th { background-color: #eaecf4; color: #4e73df; font-weight: bold; }
        
        .text-center { text-align: center; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Historial Clínico Integral</h1>
        <p>Generado el: {{ \Carbon\Carbon::now()->format('d/m/Y H:i A') }}</p>
    </div>

    <div class="box-container">
        <div class="box">
            <div class="section-title">Datos del Paciente</div>
            <ul class="data-list">
                <li><strong>Nombre:</strong> {{ $mascota->nombre }}</li>
                <li><strong>Especie/Raza:</strong> {{ $mascota->especie }} / {{ $mascota->raza }}</li>
                <li><strong>Fecha Nacimiento:</strong> {{ $mascota->fecha_nacimiento ?? 'Desconocida' }}</li>
                <li><strong>Tipo Sangre:</strong> {{ $mascota->tipo_sangre ?? 'N/A' }}</li>
                <li><strong>Comportamiento:</strong> {{ $mascota->comportamiento ?? 'N/A' }}</li>
            </ul>
        </div>
        <div class="box">
            <div class="section-title">Datos del Dueño</div>
            <ul class="data-list">
                <li><strong>Nombre:</strong> {{ $mascota->dueno->nombre_completo ?? 'N/A' }}</li>
                <li><strong>Teléfono:</strong> {{ $mascota->dueno->telefono ?? 'N/A' }}</li>
                <li><strong>Dirección:</strong> {{ $mascota->dueno->direccion ?? 'N/A' }}</li>
            </ul>
        </div>
    </div>

    <div class="section-title" style="margin-top: 20px;">Registro de Consultas y Tratamientos</div>
    
    @if($mascota->consultas->isEmpty())
        <p class="text-center">No existen consultas registradas para este paciente.</p>
    @else
        <table>
            <thead>
                <tr>
                    <th width="12%">Fecha</th>
                    <th width="18%">Veterinario</th>
                    <th width="10%">Peso/Talla</th>
                    <th width="30%">Diagnóstico</th>
                    <th width="30%">Tratamiento</th>
                </tr>
            </thead>
            <tbody>
                @foreach($mascota->consultas->sortByDesc('fecha_consulta') as $consulta)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($consulta->fecha_consulta)->format('d/m/Y') }}</td>
                        <td>{{ $consulta->veterinario->nombre_completo ?? 'N/A' }}</td>
                        <td>
                            {{ $consulta->peso ? $consulta->peso . ' kg' : '-' }}<br>
                            {{ $consulta->talla ? $consulta->talla . ' cm' : '-' }}
                        </td>
                        <td>{{ $consulta->diagnostico }}</td>
                        <td>{{ $consulta->tratamiento }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</body>
</html>
