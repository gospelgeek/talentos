<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFormalizationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('formalizations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_student');
            $table->string('acceptance_v1');
            $table->string('acceptance_v2');
            $table->string('tablets_v1');
            $table->string('tablets_v2');
            $table->string('serial_tablet');
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
        Schema::dropIfExists('formalizations');
    }
}
