<?php

namespace App\Http\Controllers;

use App\Models\Incidencia; 
use Illuminate\Http\Request;
use App\Models\User; 
use Illuminate\Support\Facades\Auth;  // Asegúrate de importar Auth

class IncidenciaController extends Controller
{
    public function index()
    {
        $user = Auth::user();  

        if ($user) {
            if ($user->role === 'admin') {  // Cambié el operador a '==='
                $incidencias = Incidencia::with('asignadoA')->get();
            } else {
                $incidencias = Incidencia::with('asignadoA')->where('assigned_to', $user->id)->get();
            }
        } else {
            return redirect()->route('login');
        }

        return view('incidencias.index', compact('incidencias'));
    }


    public function create()
    {
        $users = User::all(); 
        $user = Auth::user();

        if (!$user->role === 'admin') { 
            return response()->json(['message' => 'Unauthorized'], 403);
        }
        if ($user->role === 'soporte') {
            $users = $users->where('id', $user->id); 
        }

        return view('incidencias.create', compact('users'));
    }

    public function createUserInc( $id)
    {
        $user = Auth::user();
        $userToShow = User::findOrFail($id);

        // if ($user->role != 'admin') {
        //     return response()->json(['message' => 'Unauthorized'], 403);
        // }
        
        return view('incidencias.usuarios-create', compact('userToShow'));

    }

    public function store(Request $request)
    {
        $user = Auth::user();

        if (!$user->role === 'admin') { 
            return response()->json(['message' => 'Unauthorized'], 403);
        }
        $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'estado' => 'required|in:To Do,Doing,Done', 
            'assigned_to' => 'nullable|exists:users,id', 
        ]);

        $incidencia = new Incidencia;
        $incidencia->titulo = $request->input('titulo');
        $incidencia->descripcion = $request->input('descripcion');
        $incidencia->estado = $request->input('estado');
        $incidencia->assigned_to = $request->input('assigned_to'); 
        $incidencia->created_by = $user->id; 

        $incidencia->save();

        return redirect()->route('incidencias.index')->with('success', 'Incidencia creada correctamente.');
    }

    public function storeUserInc(Request $request)
    {
        $user = Auth::user();
        
        $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'estado' => 'required|in:To Do,Doing,Done', 
            'assigned_to' => 'nullable|exists:users,id', 
        ]);

        $incidencia = new Incidencia;
        $incidencia->titulo = $request->input('titulo');
        $incidencia->descripcion = $request->input('descripcion');
        $incidencia->estado = $request->input('estado');
        $incidencia->assigned_to = $request->input('assigned_to'); 
        $incidencia->created_by = $user->id; 

        $incidencia->save();

        return redirect()->route('usuarios.incidencias', ['id' => $incidencia->assigned_to])
            ->with('success', 'Incidencia creada correctamente.');
    }

    public function edit($id)
    {
        $user = Auth::user(); 
        $incidencia = Incidencia::findOrFail($id); 

        if (!$user->role ==='admin' && $incidencia->assigned_to !== $user->id) {
            abort(403, 'Acceso denegado'); 
        }
 
        $users = $user->role === 'admin' ? User::all() : [$user];

        return view('incidencias.edit', compact('incidencia', 'users'));
    }

    public function editUserInc($id)
    {
        $incidencia = Incidencia::findOrFail($id);
        $users = User::all(); // Obtener todos los usuarios
        return view('incidencias.usuarios-edit', compact('incidencia', 'users'));
    }

    public function update(Request $request, $id)
    {
        $user = Auth::user();

        if (!$user->role === 'admin') { 
            return response()->json(['message' => 'Unauthorized'], 403);
        }
        $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'estado' => 'required|in:To Do,Doing,Done', 
            'assigned_to' => 'required|exists:users,id',
        ]);
 
        $incidencia = Incidencia::findOrFail($id);
        
        $incidencia->titulo = $request->input('titulo');
        $incidencia->descripcion = $request->input('descripcion');
        $incidencia->estado = $request->input('estado'); 
        $incidencia->assigned_to = $request->input('assigned_to');
    
        $incidencia->save();
    
        return redirect()->route('incidencias.index')->with('success', 'Incidencia actualizada correctamente.');
    }

    public function updateUserInc(Request $request, $id)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'estado' => 'required|in:To Do,Doing,Done', 
            'assigned_to' => 'required|exists:users,id',
        ]);

        $incidencia = Incidencia::findOrFail($id);

        $incidencia->titulo = $request->input('titulo');
        $incidencia->descripcion = $request->input('descripcion');
        $incidencia->estado = $request->input('estado'); 
        $incidencia->assigned_to = $request->input('assigned_to');

        $incidencia->save();

        return redirect()->route('usuarios.incidencias', ['id' => $incidencia->assigned_to])->with('success', 'Incidencia actualizada correctamente.');
    }

    public function destroy(Incidencia $incidencia)
    {
        $user = Auth::user();
        if (!$user->role === 'admin') { 
            return response()->json(['message' => 'Unauthorized'], 403);
        }
        
        $incidencia->delete();

        return redirect()->route('incidencias.index')->with('success', 'Incidencia eliminada con éxito.');
    }

    public function destroyUserInc(Incidencia $incidencia)
    {    
        $userId = $incidencia->assigned_to;

        $incidencia->delete();

        return redirect()->route('usuarios.incidencias', ['id' => $userId])
            ->with('success', 'Incidencia eliminada con éxito.');
    }
}
