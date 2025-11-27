<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Usuario extends Authenticatable
{
    use Notifiable;

    protected $table = 'usuario';      // nombre de la tabla
    protected $primaryKey = 'id';
    public $timestamps = false;        // la tabla usuario no tiene created_at/updated_at

    protected $fillable = [
        'nombre',
        'apellidos',
        'correo',
        'contraseña',
        'direccion',
        'telefono',
        'tipoUsuario',
    ];

    protected $hidden = [
        'contraseña',
    ];

    /**
     * Laravel normalmente usa el campo "password".
     * Aquí le indicamos que use "contraseña".
     */
    public function getAuthPassword()
    {
        return $this->contraseña;
    }

    public function isAdmin(): bool
    {
        return $this->tipoUsuario === 'admin';
    }
}
