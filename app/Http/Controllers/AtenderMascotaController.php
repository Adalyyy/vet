<?php

namespace App\Http\Controllers;

use App\Models\Dueno;
use Illuminate\Http\Request;

class AtenderMascotaController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        // Buscar dueños que tengan mascotas activas, filtrados opcionalmente por nombre de mascota o dueño
        $query = Dueno::whereHas('mascotas', function ($q) {
                $q->where('activo', true);
            })
            ->with(['mascotas' => function ($q) {
                $q->where('activo', true);
            }])
            ->orderBy('created_at', 'desc');

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('nombre_completo', 'like', "%{$search}%")
                  ->orWhereHas('mascotas', function ($qm) use ($search) {
                      $qm->where('activo', true)->where('nombre', 'like', "%{$search}%");
                  });
            });
        }

        $duenos = $query->paginate(10);

        return view('modules.veterinario.atender.index', compact('duenos', 'search'));
    }
}
