<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pago extends Model
{
    // Nombre de la tabla
    protected $table = 'pago';

    // Clave primaria
    protected $primaryKey = 'id';

    // No usar timestamps (no tienes created_at / updated_at)
    public $timestamps = false;

    // Campos que se pueden asignar masivamente
    protected $fillable = [
        'boletoId',
        'numeroTarjeta',
        'titularTarjeta',
        'fechaExpiracion',
        'cvv',
        'monto',
        'fechaCompra',
    ];

    /**
     * Relación: este pago pertenece a un boleto.
     * FK: pago.boletoId -> boleto.id
     */
    public function boleto()
    {
        return $this->belongsTo(Boleto::class, 'boletoId');
        // Si en tu tabla está mal escrito como 'boletold',
        // cámbialo aquí por 'boletold'
        // return $this->belongsTo(Boleto::class, 'boletold');
    }
}
