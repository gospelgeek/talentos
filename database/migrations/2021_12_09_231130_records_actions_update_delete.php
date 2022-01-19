<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RecordsActionsUpdateDelete extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('records_actions_update_delete', function (Blueprint $table) {
            $table->increments('id');
            $table->string('identificacion');
            $table->string('nombres');
            $table->string('apellidos');
            $table->string('email');
            $table->string('rol');
            $table->string('ip');
            $table->string('id_usuario_accion');
            $table->string('nombres_usuario_accion');
            $table->string('apellidos_usuario_accion');
            $table->string('email_usuario_accion');
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
        Schema::dropIfExists('records_actions_update_delete');
    }
}
