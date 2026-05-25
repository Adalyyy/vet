<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

class UserController extends Controller
{
    public function index()
    {
        $users = User::paginate(5);
        return view('modules.admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('modules.admin.users.create');
    }

    public function store(StoreUserRequest $request)
    {
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'rol' => $request->rol,
        ]);

        return redirect()->route('admin.users.index')->with('success', 'Usuario creado correctamente.');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('modules.admin.users.edit', compact('user'));
    }

    public function update(UpdateUserRequest $request, $id)
    {
        $user = User::findOrFail($id);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'rol' => $request->rol,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('admin.users.index')->with('success', 'Usuario actualizado correctamente.');
    }

    public function show($id)
    {
        $user = User::findOrFail($id);
        return view('modules.admin.users.show', compact('user'));
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        try {
            // Si el usuario es veterinario y tiene perfil, también lo eliminamos (soft delete)
            if ($user->veterinario) {
                $user->veterinario->delete();
            }
            
            $user->delete();
            return redirect()->route('admin.users.index')->with('success', 'Usuario y su información asociada eliminados correctamente.');
        } catch (QueryException $e) {
            if ($e->getCode() == "23000") {
                return redirect()->route('admin.users.index')->with('error', 'No se puede eliminar el usuario porque tiene registros asociados en el sistema.');
            }
            return redirect()->route('admin.users.index')->with('error', 'Ocurrió un error al intentar eliminar el usuario.');
        }
    }
}
