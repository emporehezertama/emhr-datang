<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCutiKaryawan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cuti_karyawan', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->nullable();
            $table->string('jenis_cuti')->nullable();
            $table->date('tanggal_cuti_start')->nullable();
            $table->date('tanggal_cuti_end')->nullable();
            $table->text('keperluan')->nullable();
            $table->integer('backup_user_id')->nullable();
            $table->text('catatan_atasan')->nullable();
            $table->text('catatan_personalia')->nullable();
            $table->integer('status')->nullable();
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
        Schema::dropIfExists('cuti_karyawan');
    }
}
