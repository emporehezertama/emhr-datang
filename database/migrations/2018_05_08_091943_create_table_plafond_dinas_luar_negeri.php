<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTablePlafondDinasLuarNegeri extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plafond_dinas_luar_negeri', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('organisasi_position_id')->nullable();
            $table->integer('hotel')->nullable();
            $table->integer('tunjangan_makanan')->nullable();
            $table->integer('tunjangan_harian')->nullable();
            $table->integer('pesawat')->nullable();
            $table->integer('keterangan')->nullable();
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
        Schema::dropIfExists('plafond_dinas_luar_negeri');
    }
}
