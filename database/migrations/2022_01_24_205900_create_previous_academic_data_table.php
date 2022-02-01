<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePreviousAcademicDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('previous_academic_data', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_student');
            $table->integer('id_institution_type');
            $table->string('institution_name');
            $table->integer('year_graduation');
            $table->string('bachelor_title');
            $table->string('url_academic_support');
            $table->date('icfes_date');
            //$table->string('url_icfes');
            $table->string('snp_register');
            $table->integer('icfes_score');
            $table->char('graduate', 1);
            $table->string('graduate_schooling');
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
        Schema::dropIfExists('previous_academic_data');
    }
}
