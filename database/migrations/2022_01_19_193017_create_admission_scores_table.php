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
            $table->char('rural_zone', 1);
            $table->char('lgtbiq', 1);
            $table->char('disability', 1);
            $table->char('victim_conflict', 1);
            $table->char('social_reintegration', 1);
            $table->integer('strata_1_2');
            $table->integer('sisben_a_b_c');
            $table->char('afro', 1);
            $table->char('indigenous', 1);
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
