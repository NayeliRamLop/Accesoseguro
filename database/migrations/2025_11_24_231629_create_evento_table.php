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
        Schema::create('evento', function (Blueprint $table) {
            // id int(50) DEFAULT NULL -> PK autoincremental
            $table->increments('id');

            // titulo varchar(20) NOT NULL
            $table->string('titulo', 20);

            // descripcion varchar(200) NOT NULL
            $table->string('descripcion', 200);

            // fecha varchar(20) NOT NULL
            $table->string('fecha', 20);

            // hora varchar(20) NOT NULL
            $table->string('hora', 20);

            // ubicacion varchar(50) NOT NULL
            $table->string('ubicacion', 50);

            // precio double NOT NULL
            $table->double('precio');

            // urlImagen varchar(50) NOT NULL
            $table->string('urlImagen', 50);

            // boletosDisponibles int(50) NOT NULL
            $table->integer('boletosDisponibles');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('evento');
    }
};
