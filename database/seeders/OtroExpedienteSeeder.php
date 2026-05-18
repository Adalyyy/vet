<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Dueno;
use App\Models\Mascota;
use App\Models\Consulta;
use App\Models\Veterinario;

class OtroExpedienteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $veterinario = Veterinario::first();

        // Crear otro Dueño
        $dueno = Dueno::create([
            'nombre_completo' => 'María López',
            'telefono' => '555-987654',
            'direccion' => 'Avenida Siempre Viva 742'
        ]);

        // Crear otra Mascota (Gato)
        $mascota = Mascota::create([
            'dueno_id' => $dueno->id,
            'nombre' => 'Michi',
            'especie' => 'Gato',
            'raza' => 'Siamés',
            'fecha_nacimiento' => '2022-03-15',
            'tipo_sangre' => 'A',
            'comportamiento' => 'Agresivo',
            'es_adoptado' => false
        ]);

        // Crear 1 Consulta para Michi
        Consulta::create([
            'mascota_id' => $mascota->id,
            'veterinario_id' => $veterinario->id,
            'fecha_consulta' => now(),
            'peso' => 4.2,
            'talla' => 25.0,
            'diagnostico' => 'Vacunación anual y desparasitación.',
            'tratamiento' => 'Aplicación de vacuna múltiple felina. Observación por 24 horas.'
        ]);
    }
}
