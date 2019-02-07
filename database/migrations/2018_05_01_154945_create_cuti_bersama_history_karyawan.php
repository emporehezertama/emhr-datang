<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCutiBersamaHistoryKaryawan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cuti_bersama_history_karyawan', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('cuti_bersama_id')->nullable();
            $table->integer('user_id')->nullable();
            $table->integer('cuti_bersama_old')->nullable();
            $table->integer('cuti_bersama_new')->nullable();
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
        Schema::dropIfExists('cuti_bersama_history_karyawan');
    }
}
