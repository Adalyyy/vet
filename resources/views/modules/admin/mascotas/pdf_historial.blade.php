<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Historial Clínico - {{ $mascota->nombre }}</title>
    <style>
        body { font-family: Helvetica, Arial, sans-serif; font-size: 12px; color: #333; }
        .header { text-align: center; margin-bottom: 30px; border-bottom: 2px solid #1cc88a; padding-bottom: 10px; }
        .header h1 { margin: 0; color: #1cc88a; font-size: 24px; }
        .header p { margin: 5px 0 0 0; color: #666; }
        
        .box-container { width: 100%; margin-bottom: 20px; }
        .box { width: 48%; display: inline-block; vertical-align: top; }
        
        .section-title { font-size: 14px; font-weight: bold; background-color: #eaecf4; color: #1cc88a; padding: 5px 10px; margin-bottom: 10px; }
        
        .data-list { list-style: none; padding: 0; margin: 0; }
        .data-list li { margin-bottom: 5px; }
        .data-list strong { display: inline-block; width: 120px; }
        
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #d1d3e2; padding: 8px; text-align: left; vertical-align: top; }
        th { background-color: #eaecf4; color: #1cc88a; font-weight: bold; }
        
        .text-center { text-align: center; }

        .footer { margin-top: 50px; text-align: center; page-break-inside: avoid; }
        .signature-line { border-top: 1px solid #333; width: 250px; margin: 0 auto; padding-top: 5px; font-weight: bold; }
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
                    <th width="30%">Tratamiento y Medicamentos</th>
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
                        <td>
                            {{ $consulta->diagnostico }}<br><br>
                            @if($consulta->estado == 'en_seguimiento')
                                <strong><span style="color: #e74a3b;">[En Seguimiento]</span></strong>
                            @else
                                <span style="color: #1cc88a;">[Completada]</span>
                            @endif
                        </td>
                        <td>
                            @if($consulta->tratamiento)
                                <strong>Indicaciones:</strong><br>{{ $consulta->tratamiento }}<br><br>
                            @endif
                            @if($consulta->medicamentos)
                                <strong>Receta:</strong><br>{{ $consulta->medicamentos }}
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <div class="footer">
        <br><br><br>
        @php
            $veterinarioFirmante = null;
            if(auth()->check()){
                $veterinarioFirmante = \App\Models\Veterinario::where('usuario_id', auth()->id())->first();
            }
            if(!$veterinarioFirmante && $mascota->consultas->isNotEmpty()){
                $veterinarioFirmante = $mascota->consultas->sortByDesc('fecha_consulta')->first()->veterinario;
            }
        @endphp

        <div class="signature-line">
            Firma del Médico Veterinario<br>
            {{ $veterinarioFirmante->nombre_completo ?? '_______________________' }}<br>
            <small style="font-weight: normal; color: #777;">Cédula Prof: {{ $veterinarioFirmante->cedula_profesional ?? '_________________' }}</small>
        </div>
    </div>
</body>
</html>
