<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserEducationTemp extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_education_temp', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_temp_id')->nullable();
            $table->string('pendidikan')->nullable();
            $table->integer('tahun_awal')->nullable();
            $table->integer('tahun_akhir')->nullable();
            $table->string('fakultas')->nullable();
            $table->string('jurusan')->nullable();
            $table->string('nilai')->nullable();
            $table->string('kota')->nullable();
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
        Schema::dropIfExists('user_education_temp');
    }
}
