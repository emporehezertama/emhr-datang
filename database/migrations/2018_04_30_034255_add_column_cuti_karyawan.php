<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnCutiKaryawan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cuti_karyawan', function (Blueprint $table) {
            $table->dateTime('date_approved_atasan')->nullable();
            $table->integer('approved_atasan_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cuti_karyawan', function (Blueprint $table) {
            //
        });
    }
}
