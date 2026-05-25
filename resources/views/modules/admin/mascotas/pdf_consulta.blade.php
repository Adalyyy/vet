<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Consulta Médica - {{ $consulta->mascota->nombre }}</title>
    <style>
        body { font-family: Helvetica, Arial, sans-serif; font-size: 13px; color: #333; line-height: 1.5; }
        .header { text-align: center; margin-bottom: 30px; border-bottom: 2px solid #1cc88a; padding-bottom: 10px; }
        .header h1 { margin: 0; color: #1cc88a; font-size: 24px; }
        .header p { margin: 5px 0 0 0; color: #666; font-size: 14px; }
        
        .box-container { width: 100%; margin-bottom: 30px; border: 1px solid #e3e6f0; padding: 15px; background-color: #f8f9fc; }
        .box { width: 48%; display: inline-block; vertical-align: top; }
        
        .section-title { font-size: 16px; font-weight: bold; color: #1cc88a; border-bottom: 1px solid #1cc88a; padding-bottom: 5px; margin-bottom: 15px; margin-top: 20px; }
        
        .data-list { list-style: none; padding: 0; margin: 0; }
        .data-list li { margin-bottom: 8px; }
        .data-list strong { display: inline-block; width: 100px; color: #555; }
        
        .text-box { border: 1px solid #d1d3e2; padding: 15px; border-radius: 5px; background-color: #fff; min-height: 80px; margin-bottom: 20px; }
        
        .footer { margin-top: 50px; text-align: center; }
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
            <ul class="data-list">
                <li><strong>Paciente:</strong> {{ $consulta->mascota->nombre }}</li>
                <li><strong>Especie/Raza:</strong> {{ $consulta->mascota->especie }} / {{ $consulta->mascota->raza }}</li>
                <li><strong>Peso:</strong> {{ $consulta->peso ? $consulta->peso . ' kg' : 'No registrado' }}</li>
                <li><strong>Talla:</strong> {{ $consulta->talla ? $consulta->talla . ' cm' : 'No registrada' }}</li>
            </ul>
        </div>
        <div class="box">
            <ul class="data-list">
                <li><strong>Dueño:</strong> {{ $consulta->mascota->dueno->nombre_completo ?? 'N/A' }}</li>
                <li><strong>Teléfono:</strong> {{ $consulta->mascota->dueno->telefono ?? 'N/A' }}</li>
                <li><strong>Atendió:</strong> {{ $consulta->veterinario->nombre_completo ?? 'Veterinario' }}</li>
                <li><strong>Especialidad:</strong> {{ $consulta->veterinario->especialidad ?? 'General' }}</li>
            </ul>
        </div>
    </div>

    <div class="section-title">Diagnóstico Clínico</div>
    <div class="text-box">
        {!! nl2br(e($consulta->diagnostico)) !!}
    </div>

    <div class="section-title">Tratamiento e Indicaciones</div>
    <div class="text-box">
        {!! nl2br(e($consulta->tratamiento)) !!}
    </div>

    <div class="footer">
        <br><br><br>
        <div class="signature-line">
            Firma del Médico Veterinario<br>
            {{ $consulta->veterinario->nombre_completo ?? '' }}<br>
            <small style="font-weight: normal; color: #777;">Cédula Prof: {{ $consulta->veterinario->cedula_profesional ?? 'N/A' }}</small>
        </div>
    </div>
</body>
</html>
