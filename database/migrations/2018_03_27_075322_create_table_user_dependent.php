<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableUserDependent extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_dependent', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->nullable();
            $table->string('nama_pasangan')->nullable();
            $table->string('nama_anak_1')->nullable();
            $table->string('nama_anak_2')->nullable();
            $table->string('nama_anak_3')->nullable();
            $table->string('nama_anak_4')->nullable();
            $table->string('nama_anak_5')->nullable();
            $table->string('nama_ayah_kandung')->nullable();
            $table->string('nama_ibu_kandung')->nullable();

            $table->string('hubungan_pasanganan')->nullable();
            $table->string('hubungan_anak_1')->nullable();
            $table->string('hubungan_anak_2')->nullable();
            $table->string('hubungan_anak_3')->nullable();
            $table->string('hubungan_anak_4')->nullable();
            $table->string('hubungan_anak_5')->nullable();
            $table->string('hubungan_ayah_kandung')->nullable();

            $table->string('tempat_lahir_pasang')->nullable();
            $table->string('tempat_lahir_anak_1')->nullable();
            $table->string('tempat_lahir_anak_2')->nullable();
            $table->string('tempat_lahir_anak_3')->nullable();
            $table->string('tempat_lahir_anak_4')->nullable();
            $table->string('tempat_lahir_anak_5')->nullable();
            $table->string('tempat_lahir_ayah_kandung')->nullable();
            $table->string('tempat_lahir_ibu_kandung')->nullable();

            $table->string('tanggal_lahir_pasangan')->nullable();
            $table->string('tanggal_lahir_anak_1')->nullable();
            $table->string('tanggal_lahir_anak_2')->nullable();
            $table->string('tanggal_lahir_anak_3')->nullable();
            $table->string('tanggal_lahir_anak_4')->nullable();
            $table->string('tanggal_lahir_anak_5')->nullable();
            $table->string('tanggal_lahir_ayah_kandung')->nullable();
            $table->string('tanggal_lahir_ibu_kandung')->nullable();

            $table->string('tanggal_meninggal_pasangan')->nullable();
            $table->string('tanggal_meninggal_anak_1')->nullable();
            $table->string('tanggal_meninggal_anak_2')->nullable();
            $table->string('tanggal_meninggal_anak_3')->nullable();
            $table->string('tanggal_meninggal_anak_4')->nullable();
            $table->string('tanggal_meninggal_anak_5')->nullable();
            $table->string('tanggal_meninggal_ayah_kandung')->nullable();
            $table->string('tanggal_meninggal_ibu_kandung')->nullable();

            $table->string('lulusan_pasangan')->nullable();
            $table->string('lulusan_anak_1')->nullable();
            $table->string('lulusan_anak_2')->nullable();
            $table->string('lulusan_anak_3')->nullable();
            $table->string('lulusan_anak_4')->nullable();
            $table->string('lulusan_anak_5')->nullable();
            $table->string('lulusan_ayah_kandung')->nullable();
            $table->string('lulusan_ibu_kandung')->nullable();

            $table->string('pekerjaan_pasangan')->nullable();
            $table->string('pekerjaan_anak_1')->nullable();
            $table->string('pekerjaan_anak_2')->nullable();
            $table->string('pekerjaan_anak_3')->nullable();
            $table->string('pekerjaan_anak_4')->nullable();
            $table->string('pekerjaan_anak_5')->nullable();
            $table->string('pekerjaan_ayah_kandung')->nullable();
            $table->string('pekerjaan_ibu_kandung')->nullable();

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
        Schema::dropIfExists('user_dependent');
    }
}
