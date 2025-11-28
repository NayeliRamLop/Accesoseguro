<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
    }
}
