<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentProfileTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_profile', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('photo');
            $table->string('name');
            $table->string('lastname');
            $table->integer('id_document_type');
            $table->string('url_document_type');
            $table->string('document_number');
            $table->date('document_expedition_date');
            $table->string('email')->unique();
            $table->date('birth_date');
            $table->integer('id_birth_department');
            $table->integer('id_birth_city');
            $table->char('sex', 1);
            $table->integer('id_gender');
            //$table->string('landline');
            $table->string('cellphone');
            $table->string('phone');
            $table->integer('id_commune');
            $table->integer('id_neighborhood');
            $table->string('student_code');
            //$table->string('college');
            //$table->date('registration_date');
            $table->string('direction');
            $table->integer('id_tutor');
            $table->integer('id_state');
            $table->integer('id_moodle');
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
        Schema::dropIfExists('student_profile');
    }
}
