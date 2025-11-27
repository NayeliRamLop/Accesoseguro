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
        Schema::create('boleto', function (Blueprint $table) {
            // id int(50) DEFAULT NULL -> PK autoincremental
            $table->increments('id');

            // eventoId int(50) NOT NULL
            $table->integer('eventoId');

            // usuarioId int(50) NOT NULL
            $table->integer('usuarioId');

<<<<<<< HEAD
            // fechaCompra varchar(20) NOT NULL
            $table->string('fechaCompra', 20);
=======
>>>>>>> fac93c9e74fbc81afc92a4b034984aa93cb4236d

            // cantidad int(2) NOT NULL
            $table->integer('cantidad');

            // precioTotal double NOT NULL
            $table->double('precioTotal');

            // codigoQr varchar(20) NOT NULL
            $table->string('codigoQr', 20);

            // estaUsado tinyint(1) NOT NULL → 0 no usado, 1 usado
            $table->boolean('estaUsado');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('boleto');
    }
};
