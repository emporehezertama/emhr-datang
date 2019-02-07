<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Absensi extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('absensi_item', function (Blueprint $table) {
            $table->increments('id');
            $tale->integer('absensi_id')->nullable();
            $table->integer('user_id')->nullable();
            $table->string('emp_no')->nullable();
            $table->string('ac_no')->nullable();
            $table->string('name')->nullable();
            $table->string('auto_assign')->nullable();
            $table->date('date')->nullable();
            $table->string('timetable')->nullable();
            $table->string('on_dutty')->nullable();
            $table->string('off_dutty')->nullable();
            $table->string('clock_in')->nullable();
            $table->string('clock_out')->nullable();
            $table->string('normal')->nullable();
            $table->string('real_time')->nullable();
            $table->string('late')->nullable();
            $table->string('early')->nullable();
            $table->string('absent')->nullable();
            $table->string('ot_time')->nullable();
            $table->string('work_time')->nullable();
            $table->string('exception')->nullable();
            $table->string('must_c_in')->nullable();
            $table->string('must_c_out')->nullable();
            $table->string('department')->nullable();
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
        Schema::dropIfExists('absensi_item');
    }
}
