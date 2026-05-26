<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mascota;
use App\Models\Consulta;

class ExpedienteController extends Controller
{
    // public function consultas(Mascota $mascota) removed

    public function consultaDetalle(Mascota $mascota, Consulta $consulta)
    {
        // Validar que la consulta pertenezca a la mascota
        if ($consulta->mascota_id !== $mascota->id) {
            abort(404);
        }

        $consulta->load('veterinario');
        $mascota->load('dueno');
        $showSidebar = true;

        return view('expedientes.consulta_detalle', compact('mascota', 'consulta', 'showSidebar'));
    }

    public function updateConsulta(Request $request, Mascota $mascota, Consulta $consulta)
    {
        // Validar que la consulta pertenezca a la mascota
        if ($consulta->mascota_id !== $mascota->id) {
            abort(404);
        }

        $request->validate([
            'diagnostico_nuevo' => 'nullable|string',
            'tratamiento_nuevo' => 'nullable|string',
            'medicamentos_nuevo' => 'nullable|string',
            'estado' => 'required|in:cerrada,en_seguimiento',
        ]);

        $fecha = now()->format('d/m/Y H:i');
        
        $diagnostico = $consulta->diagnostico;
        if ($request->filled('diagnostico_nuevo')) {
            $diagnostico .= "\n\n--- Seguimiento ({$fecha}) ---\n" . $request->diagnostico_nuevo;
        }

        $tratamiento = $consulta->tratamiento;
        if ($request->filled('tratamiento_nuevo')) {
            if (empty($tratamiento)) {
                $tratamiento = "--- Seguimiento ({$fecha}) ---\n" . $request->tratamiento_nuevo;
            } else {
                $tratamiento .= "\n\n--- Seguimiento ({$fecha}) ---\n" . $request->tratamiento_nuevo;
            }
        }

        $medicamentos = $consulta->medicamentos;
        if ($request->filled('medicamentos_nuevo')) {
            if (empty($medicamentos)) {
                $medicamentos = "--- Seguimiento ({$fecha}) ---\n" . $request->medicamentos_nuevo;
            } else {
                $medicamentos .= "\n\n--- Seguimiento ({$fecha}) ---\n" . $request->medicamentos_nuevo;
            }
        }

        $consulta->update([
            'diagnostico' => $diagnostico,
            'tratamiento' => $tratamiento,
            'medicamentos' => $medicamentos,
            'estado' => $request->estado,
        ]);

        return redirect()->back()->with('success', 'Seguimiento registrado exitosamente.');
    }

    public function diagnostico(Mascota $mascota, Consulta $consulta)
    {
        // Validar que la consulta pertenezca a la mascota
        if ($consulta->mascota_id !== $mascota->id) {
            abort(404);
        }

        $showSidebar = true;

        return view('expedientes.diagnostico', compact('mascota', 'consulta', 'showSidebar'));
    }

    public function createConsulta(Mascota $mascota)
    {
        $mascota->load(['antecedentes', 'consultas' => function($query) {
            $query->orderBy('fecha_consulta', 'desc');
        }]);
        $showSidebar = true;
        return view('expedientes.consultas_create', compact('mascota', 'showSidebar'));
    }

    public function storeConsulta(Request $request, Mascota $mascota)
    {
        $request->validate([
            'peso' => 'nullable|numeric|min:0',
            'talla' => 'nullable|numeric|min:0',
            'diagnostico' => 'required|string',
            'tratamiento' => 'nullable|string',
            'medicamentos' => 'nullable|string',
            'estado' => 'required|in:cerrada,en_seguimiento',
        ]);

        $veterinario = \App\Models\Veterinario::where('usuario_id', auth()->id())->first();

        if (!$veterinario) {
            return redirect()->back()->withErrors(['veterinario' => 'No se encontró un perfil de veterinario asociado a tu cuenta. Contacta al administrador.']);
        }

        $consulta = new Consulta([
            'veterinario_id' => $veterinario->id,
            'fecha_consulta' => now(),
            'peso' => $request->peso,
            'talla' => $request->talla,
            'diagnostico' => $request->diagnostico,
            'tratamiento' => $request->tratamiento,
            'medicamentos' => $request->medicamentos,
            'estado' => $request->estado,
        ]);

        $mascota->consultas()->save($consulta);

        return redirect()->route('mascotas.show', $mascota->id)->with('success', 'Consulta registrada exitosamente.');
    }
}
