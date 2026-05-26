<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function index(){
        return view("modules/auth/login");
    }

    public function logear(Request $request) {
        $creadenciales = [
            'email' => $request->email,
            'password' => $request->password
        ];

        if (Auth::attempt($creadenciales)) {
            return match (Auth::user()->rol) {
                'administrador' => to_route('admin.home'),
                'veterinario' => to_route('home'),
                default => to_route('home'),
            };
        } else {
            return to_route('login');
        }
    }

    public function logout() {
        Session::flush();
        Auth::logout();
        return to_route('login');
    }

    public function home() {
        $stats = [
            'pacientes' => \App\Models\Mascota::where('activo', true)->count(),
            'consultas_hoy' => \App\Models\Consulta::whereDate('fecha_consulta', today())->count(),
            'propietarios' => \App\Models\Dueno::count(),
            'citas_pendientes' => \App\Models\Cita::where('estado', 'pendiente')->count(),
        ];

        $proximasCitas = \App\Models\Cita::with(['mascota.dueno', 'veterinario'])
            ->where('estado', 'pendiente')
            ->whereDate('fecha_hora', '>=', today())
            ->orderBy('fecha_hora', 'asc')
            ->take(5)
            ->get();

        $consultasRecientes = \App\Models\Consulta::with(['mascota', 'veterinario'])
            ->orderBy('fecha_consulta', 'desc')
            ->take(5)
            ->get();

        return view('modules.dashboard.home', compact('stats', 'proximasCitas', 'consultasRecientes'));
    }

    public function adminHome() {
        $stats = [
            'veterinarios' => \App\Models\Veterinario::count(),
            'consultas' => \App\Models\Consulta::count(),
            'usuarios' => \App\Models\User::count(),
            'mascotas' => \App\Models\Mascota::count(),
        ];
        
        $ultimasMascotas = \App\Models\Mascota::with('dueno')->orderBy('created_at', 'desc')->take(5)->get();
        $ultimasConsultas = \App\Models\Consulta::with(['mascota', 'veterinario'])->orderBy('fecha_consulta', 'desc')->take(5)->get();

        return view('modules/admin/dashboard', compact('stats', 'ultimasMascotas', 'ultimasConsultas'));
    }
}
