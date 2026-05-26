<?php

namespace App\Http\Controllers;

use App\Models\Dueno;
use Illuminate\Http\Request;

class DuenoController extends Controller
{
    public function index()
    {
        $duenos = Dueno::withCount('mascotas')->paginate(10);
        return view('modules.veterinario.duenos.index', compact('duenos'));
    }

    public function create()
    {
        return view('modules.veterinario.duenos.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre_completo' => 'required|string|max:255',
            'telefono' => 'required|string|max:20',
            'direccion' => 'required|string',
            'redes_sociales' => 'nullable|string|max:255',
            // Validaciones opcionales para la mascota
            'mascota_nombre' => 'nullable|string|max:255',
            'mascota_especie' => 'nullable|string|max:255',
            'mascota_raza' => 'nullable|string|max:255',
            'mascota_fecha_nacimiento' => 'required_with:mascota_nombre|date',
            'mascota_edad' => 'nullable|string|max:100',
            'mascota_tipo_sangre' => 'nullable|string|max:100',
        ]);

        $dueno = Dueno::create($request->only(['nombre_completo', 'telefono', 'direccion', 'redes_sociales']));

        // Si se envió el nombre de la mascota, la registramos
        if ($request->filled('mascota_nombre')) {
            $dueno->mascotas()->create([
                'nombre' => $request->mascota_nombre,
                'especie' => $request->mascota_especie,
                'raza' => $request->mascota_raza,
                'fecha_nacimiento' => $request->mascota_fecha_nacimiento,
                'edad' => $request->mascota_edad,
                'tipo_sangre' => $request->mascota_tipo_sangre,
                'comportamiento' => $request->mascota_comportamiento,
                'es_adoptado' => $request->has('mascota_es_adoptado') ? true : false,
            ]);
        }

        return redirect()->route('duenos.index')->with('success', 'Dueño/Propietario registrado exitosamente.');
    }

    public function show(Dueno $dueno)
    {
        $dueno->load('mascotas');
        return view('modules.veterinario.duenos.show', compact('dueno'));
    }

    public function edit(Dueno $dueno)
    {
        $dueno->load('mascotas');
        return view('modules.veterinario.duenos.edit', compact('dueno'));
    }

    public function update(Request $request, Dueno $dueno)
    {
        $request->validate([
            'nombre_completo' => 'required|string|max:255',
            'telefono' => 'required|string|max:20',
            'direccion' => 'required|string',
            'redes_sociales' => 'nullable|string|max:255',
        ]);

        $dueno->update($request->all());

        return redirect()->route('duenos.index')->with('success', 'Dueño actualizado exitosamente.');
    }

    public function storeMascota(Request $request, Dueno $dueno)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'especie' => 'required|string|max:255',
            'raza' => 'required|string|max:255',
            'fecha_nacimiento' => 'required|date',
            'edad' => 'nullable|string|max:100',
            'tipo_sangre' => 'nullable|string|max:100',
        ]);

        $dueno->mascotas()->create([
            'nombre' => $request->nombre,
            'especie' => $request->especie,
            'raza' => $request->raza,
            'fecha_nacimiento' => $request->fecha_nacimiento,
            'edad' => $request->edad,
            'tipo_sangre' => $request->tipo_sangre,
            'comportamiento' => $request->comportamiento,
            'es_adoptado' => $request->has('es_adoptado') ? true : false,
        ]);

        return redirect()->route('duenos.edit', $dueno->id)->with('success', 'Mascota registrada exitosamente y vinculada al propietario.');
    }

    public function destroy(Dueno $dueno)
    {
        // Verificar si tiene mascotas, tal vez no dejar eliminar si las tiene.
        if($dueno->mascotas()->count() > 0) {
            return redirect()->route('duenos.index')->with('error', 'No se puede eliminar el dueño porque tiene mascotas registradas.');
        }

        $dueno->delete();
        return redirect()->route('duenos.index')->with('success', 'Dueño eliminado exitosamente.');
    }
}
