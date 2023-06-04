<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCourseMoodlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('course_moodles', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id('id');
            $table->string('fullname')->unique();
            $table->integer('course_id');
            $table->integer('instance_id');
            $table->integer('attendance_id');
            $table->integer('group_id');
            $table->integer('docente_id');
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
        Schema::dropIfExists('course_moodles');
    }
}
