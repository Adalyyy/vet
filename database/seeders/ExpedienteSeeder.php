<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Dueno;
use App\Models\Mascota;
use App\Models\Consulta;
use App\Models\Veterinario;
use App\Models\User;

class ExpedienteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Obtener o crear un veterinario de prueba
        $veterinario = Veterinario::first();
        if (!$veterinario) {
            $user = User::firstOrCreate(
                ['email' => 'vet@example.com'],
                ['name' => 'Dr. Vet', 'password' => bcrypt('password'), 'rol' => 'veterinario']
            );
            $veterinario = Veterinario::create([
                'usuario_id' => $user->id,
                'nombre_completo' => 'Dr. Veterinario Prueba',
                'especialidad' => 'General',
                'cedula_profesional' => '12345678',
                'foto_firma' => 'firma.jpg'
            ]);
        }

        // Crear Dueño
        $dueno = Dueno::create([
            'nombre_completo' => 'Juan Pérez',
            'telefono' => '555-123456',
            'direccion' => 'Calle Falsa 123, Ciudad'
        ]);

        // Crear Mascota
        $mascota = Mascota::create([
            'dueno_id' => $dueno->id,
            'nombre' => 'Firulais',
            'especie' => 'Perro',
            'raza' => 'Mestizo',
            'fecha_nacimiento' => '2020-05-10',
            'tipo_sangre' => 'DEA 1.1',
            'comportamiento' => 'Tranquilo',
            'es_adoptado' => true
        ]);

        // Crear 2 Consultas
        Consulta::create([
            'mascota_id' => $mascota->id,
            'veterinario_id' => $veterinario->id,
            'fecha_consulta' => now()->subDays(30),
            'peso' => 15.5,
            'talla' => 45.0,
            'diagnostico' => 'Chequeo general, mascota en excelente estado de salud.',
            'tratamiento' => 'Se aplicaron vitaminas de rutina. Cita abierta para seguimiento.'
        ]);

        Consulta::create([
            'mascota_id' => $mascota->id,
            'veterinario_id' => $veterinario->id,
            'fecha_consulta' => now(),
            'peso' => 16.0,
            'talla' => 45.0,
            'diagnostico' => 'Presenta leve infección en el oído derecho (Otitis).',
            'tratamiento' => 'Limpieza ótica. Aplicar gotas óticas antibióticas cada 12 horas por 7 días.'
        ]);
    }
}
