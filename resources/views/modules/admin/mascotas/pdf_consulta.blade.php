<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Consulta Médica - {{ $consulta->mascota->nombre }}</title>
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
        <h1>Reporte de Consulta Médica</h1>
        <p>Fecha de Atención: {{ \Carbon\Carbon::parse($consulta->fecha_consulta)->format('d/m/Y') }}</p>
    </div>

    <div class="box-container">
        <div class="box">
            <div class="section-title">Datos del Paciente</div>
            <ul class="data-list">
                <li><strong>Paciente:</strong> {{ $consulta->mascota->nombre }}</li>
                <li><strong>Especie/Raza:</strong> {{ $consulta->mascota->especie }} / {{ $consulta->mascota->raza }}</li>
                <li><strong>Peso:</strong> {{ $consulta->peso ? $consulta->peso . ' kg' : 'No registrado' }}</li>
                <li><strong>Talla:</strong> {{ $consulta->talla ? $consulta->talla . ' cm' : 'No registrada' }}</li>
            </ul>
        </div>
        <div class="box">
            <div class="section-title">Datos del Veterinario y Dueño</div>
            <ul class="data-list">
                <li><strong>Dueño:</strong> {{ $consulta->mascota->dueno->nombre_completo ?? 'N/A' }}</li>
                <li><strong>Teléfono:</strong> {{ $consulta->mascota->dueno->telefono ?? 'N/A' }}</li>
                <li><strong>Atendió:</strong> {{ $consulta->veterinario->nombre_completo ?? 'Veterinario' }}</li>
                <li><strong>Especialidad:</strong> {{ $consulta->veterinario->especialidad ?? 'General' }}</li>
            </ul>
        </div>
    </div>

    <div class="section-title" style="margin-top: 20px;">Detalles de la Consulta</div>
    
    <table>
        <thead>
            <tr>
                <th width="50%">Diagnóstico Clínico</th>
                <th width="50%">Tratamiento e Indicaciones</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    {!! nl2br(e($consulta->diagnostico)) !!}<br><br>
                    @if($consulta->estado == 'en_seguimiento')
                        <strong><span style="color: #e74a3b;">[En Seguimiento]</span></strong>
                    @else
                        <span style="color: #1cc88a;">[Completada]</span>
                    @endif
                </td>
                <td>
                    {!! nl2br(e($consulta->tratamiento)) !!}
                    @if($consulta->medicamentos)
                        <br><br><strong>Receta Médica:</strong><br>
                        {!! nl2br(e($consulta->medicamentos)) !!}
                    @endif
                </td>
            </tr>
        </tbody>
    </table>

    <div class="footer">
        <br><br><br>
        <div class="signature-line">
            Firma del Médico Veterinario<br>
            {{ $consulta->veterinario->nombre_completo ?? '_______________________' }}<br>
            <small style="font-weight: normal; color: #777;">Cédula Prof: {{ $consulta->veterinario->cedula_profesional ?? '_________________' }}</small>
        </div>
    </div>
</body>
</html>
