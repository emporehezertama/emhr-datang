<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnPayroll extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('payroll', function (Blueprint $table) {
            $table->integer('bpjs_jkk_company')->nullable();
            $table->integer('bpjs_jkm_company')->nullable();
            $table->integer('bpjs_jht_company')->nullable();
            $table->integer('bpjs_jaminan_jht_employee')->nullable();
            $table->integer('bpjs_jaminan_jp_employee')->nullable();
        });

        Schema::table('payroll_history', function (Blueprint $table) {
            $table->integer('bpjs_jkk_company')->nullable();
            $table->integer('bpjs_jkm_company')->nullable();
            $table->integer('bpjs_jht_company')->nullable();
            $table->integer('bpjs_jaminan_jht_employee')->nullable();
            $table->integer('bpjs_jaminan_jp_employee')->nullable();
            $table->integer('bpjs_kesehatan_employee')->nullable();
            $table->integer('bpjs_pensiun_company')->nullable();
            $table->integer('bpjs_kesehatan_company')->nullable();
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
