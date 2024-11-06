<?php

namespace App\Http\Controllers;

use App\Models\Incidencia; 
use Illuminate\Http\Request;
use App\Models\User; 


class IncidenciaController extends Controller
{
    
    public function index()
    {
        $user = auth()->user(); 

        if ($user->hasRole('admin')) {
            $incidencias = Incidencia::with('asignadoA')->get();
        } else {
            
            $incidencias = Incidencia::with('asignadoA')->where('assigned_to', $user->id)->get();
        }

        return view('incidencias.index', compact('incidencias'));
    }

    public function create()
    {
        $users = User::all(); 
        $user = auth()->user();

        if (!$user->hasRole('admin')) { 
            return response()->json(['message' => 'Unauthorized'], 403);
        }
        if (!$user->hasRole('admin')) {
            $users = $users->where('id', $user->id); 
        }

        return view('incidencias.create', compact('users'));
    }

    public function createUserInc( $user)
    {
        return view('incidencias.usuarios-create', compact('user'));
    }

    public function store(Request $request)
    {
        $user = auth()->user();

        if (!$user->hasRole('admin')) { 
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
        $incidencia->created_by = auth()->user()->id; 

        $incidencia->save();

        return redirect()->route('incidencias.index')->with('success', 'Incidencia creada correctamente.');
    }

    public function storeUserInc(Request $request)
    {
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
        $incidencia->created_by = auth()->user()->id; 

        $incidencia->save();

        return redirect()->route('usuarios.incidencias' , ['id' => $incidencia->assigned_to])->with('success', 'Incidencia creada correctamente.');
    }

    public function edit($id)
    {
        $user = auth()->user(); 
        $incidencia = Incidencia::findOrFail($id); 

        if (!$user->hasRole('admin') && $incidencia->assigned_to !== $user->id) {
            abort(403, 'Acceso denegado'); 
        }
 
        $users = $user->hasRole('admin') ? User::all() : [$user];

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
        $user = auth()->user();

        if (!$user->hasRole('admin')) { 
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
        $user = auth()->user();

        if (!$user->hasRole('admin')) { 
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
