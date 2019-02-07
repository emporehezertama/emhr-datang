<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePayrollPph extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payroll_pph', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('batas_bawah')->nullable();
            $table->integer('batas_atas')->nullable();
            $table->integer('tarif')->nullable();
            $table->integer('pajak_minimal')->nullable();
            $table->integer('akumulasi_pajak')->nullable();
            $table->string('kondisi_lain')->nullable();
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
        Schema::dropIfExists('payroll_pph');
    }
}
