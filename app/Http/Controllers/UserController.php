<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Incidencia;


class UserController extends Controller {

    // Obtener todos los usuarios (solo accesible para admin)
    public function index() {
        $user = Auth::user();

        if ($user->role === 'admin') { 
            return response()->json(User::all(), 200);
        } else {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
    }

    public function show($id) {
        $user = Auth::user();
        $requestedUser = User::findOrFail($id);

        if (($user->role === 'admin') || ($user->role === 'soporte') && $user->id == $requestedUser->id) {
            
            return response()->json($requestedUser, 200);
        }

        return response()->json(['message' => 'Unauthorized'], 403);
    }

    public function showUsers(){

        $user = Auth::user();

        //vista según el rol
        if ($user->role === 'admin') {
            $users = User::whereHas('roles', function ($query) {
                $query->where('name', 'soporte');})->get(); 

                return view('admin.usuarios-soporte', ['users'=>$users]);
        } elseif ($user->role === 'soporte') {
            abort(403, 'Acceso denegado'); 
        }
 
    }

    // Crear un nuevo usuario (solo accesible para admin)
    public function store(Request $request) {
        $user = Auth::user();

        if (!$user->role === 'admin') {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|string|in:admin,soporte,user', 
        ]);

        $data['password'] = bcrypt($data['password']);
        $newUser = User::create($data);

        $newUser->assignRole($data['role']);

        return response()->json($newUser, 201);
    }

    public function update(Request $request, $id) {
        $user = Auth::user();
        $requestedUser = User::findOrFail($id);

        if (!$user->role === 'admin' && $user->id !== $requestedUser->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $data = $request->validate([
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|string|email|max:255|unique:users,email,' . $requestedUser->id,
            'password' => 'sometimes|string|min:8|confirmed',
            'role' => 'sometimes|string|in:admin,soporte,user',
        ]);

        if (isset($data['password'])) {
            $data['password'] = bcrypt($data['password']);
        }

        $requestedUser->update($data);

        if ($user->role === 'admin' && isset($data['role'])) {
            $requestedUser->syncRoles([$data['role']]);
        }

        return response()->json($requestedUser, 200);
    }

    // Eliminar un usuario (solo accesible para admin)
    public function destroy($id) {
        $user = Auth::user();

        if (!$user->role === 'admin') { 
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $requestedUser = User::findOrFail($id);
        $requestedUser->delete();

        return response()->json(null, 204);
    }

    public function showUserIncidencias($id)
    {
        $user = Auth::user(); 
        
        $userToShow = User::findOrFail($id);

        if ($user->role === 'admin') {
            $incidencias = Incidencia::where('assigned_to', $id)->get();
        } 
       
        elseif ($user->role === 'soporte') {
            if ($user->id != $id) {
                abort(403, 'No tienes permiso para ver estas incidencias');
            }
            
            $incidencias = Incidencia::where('assigned_to', $id)->get();
        }
        else {
            abort(403, 'No tienes permiso para ver estas incidencias');
        }

        return view('admin.detalle-usuarios', [
            'user' => $user,         
            'userToShow' => $userToShow, 
            'incidencias' => $incidencias,
        ]);
    }


    public function createUser()
    {
        $user = Auth::user();
        if (!$user->role === 'admin') {
            abort(403, 'No tienes permiso para crear usuarios');
        }
        return view('admin.crear-usuario');
    }

    public function storeUser(Request $request) {
        $user = Auth::user();
        if (!$user->role === 'admin') {
            abort(403, 'No tienes permiso para guardar usuarios');
        }
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|string|in:admin,soporte',
        ]);
    
        $data['password'] = bcrypt($data['password']);
        $newUser = User::create($data);
    
        $newUser->assignRole($data['role']);
    
        return redirect()->route('usuarios.soporte')->with('success', 'Usuario creado correctamente.');
    }

    public function destroyUser($id) {
        $user = Auth::user();

        if (!$user->role === 'admin') {
            return redirect()->route('usuarios.soporte')->with('error', 'No tienes permisos para realizar esta acción.');
        }
  
        $userToDelete = User::findOrFail($id);
        $userToDelete->delete();
    
        return redirect()->route('usuarios.soporte')->with('success', 'Usuario eliminado correctamente.');
    }
    
}
