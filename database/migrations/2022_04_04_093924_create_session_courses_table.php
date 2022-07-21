<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSessionCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('session_courses', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id('id');
            $table->integer('attendance_id');
            $table->integer('session_id');
            $table->date('sessdate');
            $table->integer('lasttaken');
            $table->string('description');
            $table->string('type');
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
        Schema::dropIfExists('session_courses');
    }
}
