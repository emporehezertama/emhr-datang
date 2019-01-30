<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserEducation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_education', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->nullable();

            $table->string('tahun_awal_sma')->nullable();
            $table->string('tahun_awal_d3')->nullable();
            $table->string('tahun_awal_s1')->nullable();
            $table->string('tahun_awal_s2')->nullable();
                
            $table->string('tahun_akhir_sma')->nullable();
            $table->string('tahun_akhir_d3')->nullable();
            $table->string('tahun_akhir_s1')->nullable();
            $table->string('tahun_akhir_s2')->nullable();

            $table->string('fakultas_sma')->nullable();
            $table->string('fakultas_d3')->nullable();
            $table->string('fakultas_s1')->nullable();
            $table->string('fakultas_s2')->nullable();

            $table->string('jurusan_sma')->nullable();
            $table->string('jurusan_d3')->nullable();
            $table->string('jurusan_s1')->nullable();
            $table->string('jurusan_s2')->nullable();

            $table->string('nilai_sma')->nullable();
            $table->string('nilai_d3')->nullable();
            $table->string('nilai_s1')->nullable();
            $table->string('nilai_s2')->nullable();

            $table->string('city_id_sma')->nullable();
            $table->string('city_id_d3')->nullable();
            $table->string('city_id_s1')->nullable();
            $table->string('city_id_s2')->nullable();

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
        Schema::dropIfExists('user_education');
    }
}
