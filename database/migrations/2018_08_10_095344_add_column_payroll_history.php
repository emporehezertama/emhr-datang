<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnPayrollHistory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('payroll_history', function (Blueprint $table) {
            $table->integer('actual_sallary')->nullable();
            $table->integer('transport_allowance')->nullable();
            $table->integer('homebase_allowance')->nullable();
            $table->integer('laptop_allowance')->nullable();
            $table->integer('ot_normal_hours')->nullable();
            $table->integer('ot_multiple_hours')->nullable();
            $table->integer('other_income')->nullable();
            $table->integer('remark_other_income')->nullable();
            $table->integer('medical_claim')->nullable();
            $table->integer('remark')->nullable();
            $table->integer('pph21')->nullable();
            $table->integer('other_deduction')->nullable();
            $table->integer('remark_other_deduction')->nullable();
            $table->integer('gross_income_per_month');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('payroll_history', function (Blueprint $table) {
            //
        });
    }
}
