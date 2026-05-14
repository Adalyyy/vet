<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'name' => 'admin',
            'email' => 'admin',
            'password' => Hash::make('admin'),
            'rol' => 'administrador',
        ]);

        User::create([
            'name' => 'veterinario',
            'email' => 'veterinario',
            'password' => Hash::make('veterinario'),
            'rol' => 'veterinario',
        ]);
    }
}
