<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mascota;

class ExpedienteController extends Controller
{
    public function index()
    {
        return view('expedientes.index');
    }

    public function search(Request $request)
    {
        $query = $request->input('query');

        if (empty($query)) {
            return response()->json([]);
        }

        // Scout search with relationship fallback for Database engine
        $resultados = Mascota::search($query)->query(function ($builder) use ($query) {
            $builder->orWhereHas('dueno', function ($q) use ($query) {
                $q->where('nombre_completo', 'like', "%{$query}%");
            });
        })->take(10)->get();

        // Transform results to a format for JS
        $data = $resultados->map(function ($mascota) {
            return [
                'id' => $mascota->id,
                'nombre' => $mascota->nombre,
                'especie' => $mascota->especie,
                'dueno_nombre' => $mascota->dueno ? $mascota->dueno->nombre_completo : 'Sin dueño',
                'url' => '#' // Placeholder para futuras rutas de ver expediente
            ];
        });

        return response()->json($data);
    }
}
