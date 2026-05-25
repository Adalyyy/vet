<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Mascota;
use Illuminate\Http\Request;

class MascotaController extends Controller
{
    public function index()
    {
        $mascotas = Mascota::with('dueno')->orderBy('created_at', 'desc')->paginate(10);
        return view('modules.admin.mascotas.index', compact('mascotas'));
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

        return view('modules.admin.mascotas.show', compact('mascota', 'veterinariosAtendieron'));
    }
}
