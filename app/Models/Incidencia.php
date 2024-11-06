<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Incidencia extends Model {
    use HasFactory;

    protected $fillable = [
        'titulo',
        'descripcion',
        'estado',
        'assigned_to',
        'created_by'
    ];

    public function asignadoA() {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function creadoPor() {
        return $this->belongsTo(User::class, 'created_by');
    }
}
