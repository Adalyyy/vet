<?php

namespace App\Http\Controllers;

use App\Models\Cita;
use App\Models\Mascota;
use App\Models\Veterinario;
use Illuminate\Http\Request;

class CitaController extends Controller
{
    public function index(Request $request)
    {
        $showSidebar = true;
        $mascotas = Mascota::where('activo', true)->get();
        $veterinarios = Veterinario::all();
        $citas = Cita::with(['mascota', 'veterinario'])->orderBy('fecha_hora', 'asc')->get();

        return view('modules.veterinario.agenda.index', compact('showSidebar', 'mascotas', 'veterinarios', 'citas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'mascota_id' => 'nullable|exists:mascotas,id',
            'nombre_invitado' => 'nullable|string|max:255',
            'veterinario_id' => 'nullable|exists:veterinarios,id',
            'motivo' => 'required|string|max:255',
            'fecha_hora' => 'required|date',
            'notas' => 'nullable|string',
        ]);

        if (empty($request->mascota_id) && empty($request->nombre_invitado)) {
            return redirect()->back()->withErrors(['Debe seleccionar una mascota registrada o ingresar un nombre de invitado.'])->withInput();
        }

        Cita::create([
            'mascota_id' => $request->mascota_id,
            'nombre_invitado' => $request->nombre_invitado,
            'veterinario_id' => $request->veterinario_id,
            'motivo' => $request->motivo,
            'fecha_hora' => $request->fecha_hora,
            'estado' => 'pendiente',
            'notas' => $request->notas,
        ]);

        return redirect()->route('citas.index')->with('success', 'Cita agendada correctamente.');
    }

    public function update(Request $request, Cita $cita)
    {
        $request->validate([
            'estado' => 'required|in:pendiente,completada,cancelada',
        ]);

        $cita->update([
            'estado' => $request->estado,
        ]);

        return redirect()->route('citas.index')->with('success', 'Estado de la cita actualizado.');
    }

    public function destroy(Cita $cita)
    {
        $cita->delete();
        return redirect()->route('citas.index')->with('success', 'Cita eliminada correctamente.');
    }

    public function exportPdf()
    {
        $citas = Cita::with(['mascota', 'veterinario'])->orderBy('fecha_hora', 'asc')->get();
        $pdf = \PDF::loadView('modules.veterinario.agenda.pdf', compact('citas'));
        return $pdf->download('Agenda_Citas.pdf');
    }
}
