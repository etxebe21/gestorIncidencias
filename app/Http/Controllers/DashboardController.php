<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        //vista según el rol
        if ($user->role === 'admin') {
            return view('admin.dashboard'); 
        } elseif ($user->role === 'soporte') {
            return view('soporte.dashboard');  
        }

        abort(403, 'Acceso denegado');
    }
}
