<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogsCrudActionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('logs_crud_actions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('identificacion');
            $table->string('nombres');
            $table->string('apellidos');
            $table->string('email');
            $table->string('rol');
            $table->string('ip');
            $table->string('id_usuario_accion');
            $table->string('actividad_realizada');
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
        Schema::dropIfExists('logs_crud_actions');
    }
}
