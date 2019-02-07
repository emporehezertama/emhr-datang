<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePayrollPtkp extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payroll_ptkp', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('bujangan_wanita')->nullable();
            $table->integer('menikah')->nullable();
            $table->integer('menikah_anak_1')->nullable();
            $table->integer('menikah_anak_2')->nullable();
            $table->integer('menikah_anak_3')->nullable();
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
        Schema::dropIfExists('payroll_ptkp');
    }
}
