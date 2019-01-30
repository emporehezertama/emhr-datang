<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableTraining extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('training', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->nullable();
            $table->string('topik_kegiatan')->nullable();
            $table->date('tanggal_kegiatan_start')->nullable();
            $table->date('tanggal_kegiatan_end')->nullable();
            $table->integer('pengambilan_uang_muka')->nullable();
            $table->date('tanggal_pengajuan')->nullable();
            $table->date('tanggal_penyelesaian')->nullable();
            $table->date('pesawat_tanggal')->nullable();
            $table->string('pesawat_perjalanan')->nullable();
            $table->string('pesawat_rute_dari')->nullable();
            $table->string('pesawat_rute_ke')->nullable(); 
            $table->string('pesawat_rute_dari_tanggal')->nullable();
            $table->string('pesawat_rute_ke_tanggal')->nullable();
            $table->string('pesawat_rute_dari_waktu')->nullable();
            $table->string('pesawat_rute_ke_waktu')->nullable();
            $table->string('pesawat_kelas')->nullable();
            $table->integer('transportasi_ticket')->nullable();
            $table->integer('transportasi_taxi')->nullable();
            $table->integer('transportasi_gasoline')->nullable();
            $table->integer('transportasi_tol')->nullable();
            $table->integer('transportasi_parkir')->nullable();
            $table->integer('hotel_plafond')->nullable();
            $table->integer('uang_saku_kegiatan')->nullable();
            $table->integer('uang_makan')->nullable();
            $table->timestamps();
        });

        Schema::create('training_biaya_lainnya', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('training_id')->nullable();
            $table->string('label')->nullable();
            $table->integer('nominal')->nullable();
        });

        Schema::create('training_penumpang', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('training_id')->nullable();
            $table->integer('user_id')->nullable();
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
        Schema::dropIfExists('training');
    }
}
