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
}
