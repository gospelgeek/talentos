<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id();
            $table->string('cedula')->unique();
            $table->string('name');
            $table->string('apellidos_user');
            $table->string('tipo_documento_user');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->Integer('rol_id');
            $table->string('password');
            $table->rememberToken();
            $table->softDeletes();
            $table->timestamps();
            //$table->primary('cedula');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
