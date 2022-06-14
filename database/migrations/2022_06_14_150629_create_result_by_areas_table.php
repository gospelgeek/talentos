<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResultByAreasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('result_by_areas', function (Blueprint $table) {
            $table->increments("id");
            $table->integer("id_student");
            $table->integer("id_icfes_student");
            $table->integer("id_icfes_area");
            $table->float("qualification");
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
        Schema::dropIfExists('result_by_areas');
    }
}
