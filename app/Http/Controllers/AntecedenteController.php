<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Mascota;
use App\Models\Antecedente;

use Illuminate\Support\Facades\Storage;

class AntecedenteController extends Controller
{
    public function index(Mascota $mascota)
    {
        $antecedentes = $mascota->antecedentes()->latest()->get();
        return view('modules.veterinario.mascotas.antecedentes.index', compact('mascota', 'antecedentes'));
    }

    public function store(Request $request, Mascota $mascota)
    {
        $request->validate([
            'tipo' => 'required|in:alergia,lesion,patologia,alimentacion',
            'descripcion' => 'required|string',
            'fecha_deteccion' => 'nullable|date',
            'archivo' => 'nullable|file|mimes:pdf,jpg,jpeg,png,doc,docx|max:5120', // Max 5MB
        ]);

        $data = $request->except('archivo');

        if ($request->hasFile('archivo')) {
            $path = $request->file('archivo')->store('antecedentes', 'public');
            $data['archivos_medicos'] = $path;
        }

        $mascota->antecedentes()->create($data);

        return redirect()->route('mascotas.antecedentes.index', $mascota->id)
                         ->with('success', 'Antecedente agregado exitosamente.');
    }

    public function update(Request $request, Mascota $mascota, Antecedente $antecedente)
    {
        $request->validate([
            'tipo' => 'required|in:alergia,lesion,patologia,alimentacion',
            'descripcion' => 'required|string',
            'fecha_deteccion' => 'nullable|date',
            'archivo' => 'nullable|file|mimes:pdf,jpg,jpeg,png,doc,docx|max:5120',
        ]);

        $data = $request->except('archivo');

        if ($request->hasFile('archivo')) {
            // Delete old file
            if ($antecedente->archivos_medicos && Storage::disk('public')->exists($antecedente->archivos_medicos)) {
                Storage::disk('public')->delete($antecedente->archivos_medicos);
            }
            $path = $request->file('archivo')->store('antecedentes', 'public');
            $data['archivos_medicos'] = $path;
        }

        $antecedente->update($data);

        return redirect()->route('mascotas.antecedentes.index', $mascota->id)
                         ->with('success', 'Antecedente actualizado exitosamente.');
    }

    public function destroy(Mascota $mascota, Antecedente $antecedente)
    {
        if ($antecedente->archivos_medicos && Storage::disk('public')->exists($antecedente->archivos_medicos)) {
            Storage::disk('public')->delete($antecedente->archivos_medicos);
        }
        
        $antecedente->delete();

        return redirect()->route('mascotas.antecedentes.index', $mascota->id)
                         ->with('success', 'Antecedente eliminado exitosamente.');
    }
}
