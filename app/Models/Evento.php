<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Evento extends Model
{
    use HasFactory;

    // nombre de la tabla
    protected $table = 'evento';

    protected $fillable = [
        'titulo',
        'descripcion',
        'fecha',
        'hora',
        'ubicacion',
        'precio',
        'urlImagen',
        'boletosDisponibles',
    ];

    // created_at y updated_at 
    public $timestamps = false;
}
