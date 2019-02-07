<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnCuti extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cuti_karyawan', function (Blueprint $table) {
            $table->smallInteger('temp_kuota')->nullable();
            $table->smallInteger('temp_cuti_terpakai')->nullable();
            $table->smallInteger('temp_sisa_cuti')->nullable();
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
