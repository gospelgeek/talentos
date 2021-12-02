<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePerfilEstudianteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('perfil_estudiante', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombres');
            $table->string('apellidos');
            $table->string('tipo_documento');
            $table->string('numero_documento');
            $table->date('fecha_nacimiento');
            $table->string('departamento_nacimiento');
            $table->string('ciudad_nacimiento');
            $table->char('sexo', 1);
            $table->string('genero');
            $table->string('departamento_residencia');
            $table->string('ciudad_residencia');
            $table->string('barrio_residencia');
            $table->string('direccion');
            $table->string('email')->unique();
            $table->string('telefono1');
            $table->string('telefono2');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('perfil_estudiante');
    }
}
