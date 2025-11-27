<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

<<<<<<< HEAD
class Evento extends Model
{
    protected $table = 'evento';

    protected $fillable = [
        'titulo',
        'descripcion',
        'fecha',
        'hora',
        'lugar',
        'boletosDisponibles',
    ];
=======
class Boleto extends Model
{
    protected $table = 'boleto';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'eventoId',
        'usuarioId',
        'cantidad',
        'precioTotal',
        'codigoQr',
        'estaUsado',
    ];

    public function evento()
    {
        return $this->belongsTo(Evento::class, 'eventoId');
    }

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuarioId');
    }

    public function pago()
    {
        return $this->hasOne(Pago::class, 'boletoId');
        // ⚠️ Igual que arriba: si la columna se llama 'boletold',
        // cambia aquí:
        // return $this->hasOne(Pago::class, 'boletold');
    }
>>>>>>> fac93c9e74fbc81afc92a4b034984aa93cb4236d
}
