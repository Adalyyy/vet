<?php

namespace App\Http\Controllers;

use App\Models\Dueno;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

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
            // Validaciones obligatorias para la mascota
            'mascota_nombre' => 'required|string|max:255',
            'mascota_especie' => 'required|string|max:255',
            'mascota_raza' => 'required|string|max:255',
            'mascota_fecha_nacimiento' => 'required|date',
            'mascota_edad' => 'nullable|string|max:100',
            'mascota_tipo_sangre' => 'nullable|string|max:100',
        ]);

        $dueno = Dueno::create($request->only(['nombre_completo', 'telefono', 'direccion', 'redes_sociales']));

        // Registramos obligatoriamente su primera mascota
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

    public function updateMascota(Request $request, \App\Models\Mascota $mascota)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'especie' => 'required|string|max:255',
            'raza' => 'required|string|max:255',
            'fecha_nacimiento' => 'required|date',
            'edad' => 'nullable|string|max:100',
            'tipo_sangre' => 'nullable|string|max:100',
        ]);

        $mascota->update([
            'nombre' => $request->nombre,
            'especie' => $request->especie,
            'raza' => $request->raza,
            'fecha_nacimiento' => $request->fecha_nacimiento,
            'edad' => $request->edad,
            'tipo_sangre' => $request->tipo_sangre,
            'comportamiento' => $request->comportamiento,
            'es_adoptado' => $request->has('es_adoptado') ? true : false,
        ]);

        return redirect()->route('duenos.edit', $mascota->dueno_id)->with('success', 'Datos de la mascota actualizados exitosamente.');
    }

    public function bajaMascota(Request $request, \App\Models\Mascota $mascota)
    {
        $request->validate([
            'motivo' => 'required|string',
            'motivo_otro' => 'nullable|string'
        ]);

        $motivoFinal = $request->motivo;
        if ($request->motivo === 'Otro' && $request->filled('motivo_otro')) {
            $motivoFinal = 'Otro: ' . $request->motivo_otro;
        }

        $mascota->update([
            'activo' => false,
            'motivo_baja' => $motivoFinal
        ]);

        $mensaje = 'Mascota dada de baja exitosamente.';
        if ($request->motivo === 'Fallecimiento') {
            $mensaje = 'Lamentamos mucho la pérdida de ' . $mascota->nombre . '. Un gran compañero que descansará en paz. Sus registros han sido archivados.';
        }

        return redirect()->route('duenos.edit', $mascota->dueno_id)->with('success', $mensaje);
    }

    public function pdfHistorico(Request $request, Dueno $dueno)
    {
        // Cargar las mascotas activas con sus consultas si se requiere
        $dueno->load(['mascotas' => function ($query) {
            $query->orderBy('activo', 'desc')->orderBy('created_at', 'desc');
        }]);

        if ($request->has('incluir_tratamientos')) {
            $dueno->load(['mascotas.consultas' => function($q) {
                $q->orderBy('fecha_consulta', 'desc');
            }]);
        } else {
            // Solo cargamos fechas y titulos/diagnosticos basicos sin tratamiento
            $dueno->load(['mascotas.consultas' => function($q) {
                $q->select('id', 'mascota_id', 'fecha_consulta', 'diagnostico')->orderBy('fecha_consulta', 'desc');
            }]);
        }

        $incluirTratamientos = $request->has('incluir_tratamientos');

        $pdf = Pdf::loadView('modules.veterinario.duenos.pdf_historico', compact('dueno', 'incluirTratamientos'));
        
        return $pdf->stream('historico_propietario_' . time() . '.pdf');
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
