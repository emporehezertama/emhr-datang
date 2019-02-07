<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnExitInterview extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('exit_interview', function (Blueprint $table) {
            $table->integer('status')->nullable();
            $table->integer('exit_interview_reason')->nullable();
            $table->text('hal_berkesan')->nullable();
            $table->text('hal_tidak_berkesan')->nullable();
            $table->text('masukan')->nullable();
            $table->text('kegiatan_setelah_resign')->nullable();
            $table->text('tujuan_perusahaan_baru')->nullable();
            $table->text('jenis_bidang_usaha')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('exit_interview', function (Blueprint $table) {
            //
        });
    }
}
