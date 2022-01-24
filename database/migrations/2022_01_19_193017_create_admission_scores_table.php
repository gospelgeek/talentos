<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdmissionScoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admission_scores', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_student');
            $table->integer('icfes_score_p1');
            $table->integer('vulnerability');
            $table->integer('formula');
            $table->integer('rural_zone');
            $table->integer('lgtbiq');
            $table->integer('disability');
            $table->integer('victim_conflict');
            $table->integer('social_reintegration');
            $table->integer('strata_1_2');
            $table->integer('sisben_a_b_c');
            $table->integer('afro');
            $table->integer('indigenous');
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
        Schema::dropIfExists('admission_scores');
    }
}
