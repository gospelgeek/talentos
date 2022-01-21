<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSocioeconomicDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('socioeconomic_data', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_student');
            $table->integer('id_ocupation');
            $table->integer('id_civil_status');
            $table->integer('children_number');
            $table->integer('id_residence_time');
            $table->integer('id_housing_type');
            $table->integer('id_health_regime');
            $table->string('url_health_regime');
            $table->string('sisben_category');
            $table->string('url_sisben_category');
            $table->integer('id_benefits');
            $table->string('household_people');
            $table->string('economic_possition');
            $table->integer('dependent_people');
            $table->boolean('internet_zon');
            $table->boolean('internet_home');
            $table->char('sex_document_identidad', 1);
            $table->boolean('id_gender');
            $table->integer('id_social_conditions');
            $table->string('url_social_conditions');
            $table->integer('id_disability');
            $table->integer('id_ethnicity');
            $table->string('url_ethnicity');
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
        Schema::dropIfExists('socioeconomic_data');
    }
}
