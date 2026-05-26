<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Mascota;

class MascotaController extends Controller
{
    public function index()
    {
        $mascotas = Mascota::with('dueno')->paginate(15);
        return view('modules.veterinario.mascotas.index', compact('mascotas'));
    }

    public function show(Mascota $mascota)
    {
        $mascota->load(['consultas.veterinario', 'dueno']);
        
        // Extraer veterinarios únicos que atendieron a la mascota
        $veterinariosAtendieron = $mascota->consultas->filter(function($consulta) {
            return $consulta->veterinario !== null;
        })->map(function ($consulta) {
            return $consulta->veterinario->nombre_completo;
        })->unique();

        return view('modules.veterinario.mascotas.show', compact('mascota', 'veterinariosAtendieron'));
    }

    public function exportHistorialPdf(Mascota $mascota)
    {
        $mascota->load(['consultas.veterinario', 'dueno']);
        
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('modules.admin.mascotas.pdf_historial', compact('mascota'));
        return $pdf->download('historial_clinico_' . strtolower(str_replace(' ', '_', $mascota->nombre)) . '.pdf');
    }

    public function exportConsultaPdf(\App\Models\Consulta $consulta)
    {
        $consulta->load(['mascota.dueno', 'veterinario']);
        
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('modules.admin.mascotas.pdf_consulta', compact('consulta'));
        return $pdf->download('consulta_' . \Carbon\Carbon::parse($consulta->fecha_consulta)->format('Ymd') . '_' . strtolower(str_replace(' ', '_', $consulta->mascota->nombre)) . '.pdf');
    }
}
