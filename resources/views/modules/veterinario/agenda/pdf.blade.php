<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Agenda de Citas</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .text-center { text-align: center; }
        .badge-pendiente { color: #856404; background-color: #fff3cd; padding: 3px; border-radius: 3px; }
        .badge-completada { color: #155724; background-color: #d4edda; padding: 3px; border-radius: 3px; }
        .badge-cancelada { color: #721c24; background-color: #f8d7da; padding: 3px; border-radius: 3px; }
    </style>
</head>
<body>
    <h2 class="text-center">Agenda Completa de Citas</h2>
    <p>Fecha de reporte: {{ now()->format('d/m/Y H:i') }}</p>

    <table>
        <thead>
            <tr>
                <th>Fecha y Hora</th>
                <th>Paciente / Invitado</th>
                <th>Motivo</th>
                <th>Veterinario Asignado</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            @foreach($citas as $cita)
            <tr>
                <td>{{ $cita->fecha_hora->format('d/m/Y H:i') }}</td>
                <td>{{ $cita->mascota_id ? $cita->mascota->nombre : 'Invitado: ' . $cita->nombre_invitado }}</td>
                <td>{{ $cita->motivo }}</td>
                <td>{{ $cita->veterinario ? $cita->veterinario->nombre_completo : 'Sin asignar' }}</td>
                <td>
                    <span class="badge-{{ $cita->estado }}">{{ strtoupper($cita->estado) }}</span>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
