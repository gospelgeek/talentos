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
            $table->string('name');
            $table->string('lastname');
            $table->integer('id_document_type');
            //$table->foreign('id_document_type')->references('id')->on('document_type');
            $table->string('document_number');
            $table->date('document_expedition_date');
            $table->string('email')->unique();
            $table->date('birth_date');
            $table->integer('id_birth_department');
            //$table->foreign('id_birth_department')->references('id')->on('birth_departaments');
            $table->integer('id_birth_city');
            //$table->foreign('id_birth_city')->references('id')->on('birth_city');
            $table->char('sex', 1);
            $table->integer('id_gender');
            //$table->foreign('id_gender')->references('id')->on('gender');
            $table->string('cellphone');
            $table->string('phone');
            $table->integer('id_commune');
            //$table->foreign('id_commune')->references('id')->on('comune');
            $table->integer('id_neighborhood');
            //$table->foreign('id_neighborhood')->references('id')->on('neighborhood');
            $table->string('direction');
            $table->integer('id_tutor');
            //$table->foreign('id_tutor')->references('id')->on('tutor');
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
