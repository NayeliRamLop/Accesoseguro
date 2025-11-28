<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pago', function (Blueprint $table) {
            // id PK autoincremental
            $table->increments('id');

            // boletoId -> con qué boleto está relacionado
            $table->integer('boletoId'); // int(50) NOT NULL en tu diseño

            // numeroTarjeta varchar(20) DEFAULT NULL
            $table->string('numeroTarjeta', 20)->nullable();

            // titularTarjeta varchar(50) NOT NULL
            $table->string('titularTarjeta', 50);

            // fechaExpiracion varchar(20) NOT NULL
            $table->string('fechaExpiracion', 20);

            // cvv varchar(3) NOT NULL
            $table->string('cvv', 3);

            // monto double NOT NULL
            $table->double('monto');
            

              // fechaCompra varchar(20) NOT NULL
            $table->string('fechaCompra', 20);

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pago');
    }
};
