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
        Schema::create('usuario', function (Blueprint $table) {
            // id int(50) NOT NULL -> PK autoincremental
            $table->increments('id');

            // nombre varchar(50) DEFAULT NULL
            $table->string('nombre', 50)->nullable();

            // apellidos varchar(50) DEFAULT NULL
            $table->string('apellidos', 50)->nullable();

            // correo varchar(50) DEFAULT NULL (para login)
            $table->string('correo', 50)->nullable();

            // contraseña -> 255 para guardar hash bcrypt
            $table->string('contraseña', 255)->nullable();

            // direccion varchar(50) DEFAULT NULL
            $table->string('direccion', 50)->nullable();

            // telefono varchar(20) DEFAULT NULL
            $table->string('telefono', 20)->nullable();

            // tipoUsuario varchar(20) NOT NULL
            // móvil: admin | noAdmin
            // web: solo admin
            $table->string('tipoUsuario', 20);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usuario');
    }
};
