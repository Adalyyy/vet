<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class HistorialUsuarioController extends Controller
{
    public function index()
    {
        // Obtener usuarios eliminados, incluyendo su perfil de veterinario eliminado si aplica
        $usuariosEliminados = User::onlyTrashed()->with(['veterinario' => function ($query) {
            $query->withTrashed();
        }])->paginate(10);

        return view('modules.admin.historial_usuarios.index', compact('usuariosEliminados'));
    }
}
