<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnPayroll2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('payroll', function (Blueprint $table) {
            $table->integer('bpjs_ketenagakerjaan_company')->nullable();
            $table->integer('bpjs_kesehatan_company')->nullable();
            $table->integer('bpjs_pensiun_company')->nullable();
            $table->integer('bpjs_ketenagakerjaan_employee')->nullable();
            $table->integer('bpjs_kesehatan_employee')->nullable();
            $table->integer('bpjs_pensiun_employee')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('payroll', function (Blueprint $table) {
            //
        });
    }
}
