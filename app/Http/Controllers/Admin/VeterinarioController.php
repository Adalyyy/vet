<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Veterinario;
use App\Models\User;
use Illuminate\Http\Request;

class VeterinarioController extends Controller
{
    public function index()
    {
        $veterinarios = Veterinario::with('user')->paginate(5);
        return view('modules.admin.veterinarios.index', compact('veterinarios'));
    }

    public function create()
    {
        $usuarios = User::where('rol', 'veterinario')
            ->whereDoesntHave('veterinario')
            ->get();
            
        return view('modules.admin.veterinarios.create', compact('usuarios'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'usuario_id' => 'required|exists:users,id',
            'nombre_completo' => 'required|string|max:255',
            'telefono' => 'required|string|max:20',
            'cedula_profesional' => 'required|string|max:50',
            'anio_antiguedad' => 'required|integer|min:0',
            'especialidad' => 'required|string|max:255',
        ]);

        Veterinario::create($request->all());

        return redirect()->route('admin.veterinarios.index')->with('success', 'Veterinario registrado correctamente.');
    }

    public function show($id)
    {
        $veterinario = Veterinario::findOrFail($id);
        return view('modules.admin.veterinarios.show', compact('veterinario'));
    }

    public function edit($id)
    {
        $veterinario = Veterinario::findOrFail($id);
        return view('modules.admin.veterinarios.edit', compact('veterinario'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre_completo' => 'required|string|max:255',
            'telefono' => 'required|string|max:20',
            'cedula_profesional' => 'required|string|max:50',
            'anio_antiguedad' => 'required|integer|min:0',
            'especialidad' => 'required|string|max:255',
        ]);

        $veterinario = Veterinario::findOrFail($id);
        $veterinario->update($request->all());

        return redirect()->route('admin.veterinarios.index')->with('success', 'Veterinario actualizado correctamente.');
    }

    public function destroy($id)
    {
        $veterinario = Veterinario::findOrFail($id);
        $veterinario->delete();

        return redirect()->route('admin.veterinarios.index')->with('success', 'Veterinario eliminado correctamente.');
    }
}
