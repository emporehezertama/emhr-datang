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
            $table->integer('user_id')->nullable();
            $table->integer('salary')->nullable();
            $table->decimal('jkk',8,2)->nullable();
            $table->integer('jkk_result')->nullable();
            $table->integer('call_allow')->nullable();
            $table->integer('bonus')->nullable();
            $table->integer('gross_income')->nullable();
            $table->integer('burden_allow')->nullable();
            $table->decimal('jamsostek',8,2)->nullable();
            $table->integer('jamsostek_result')->nullable();
            $table->integer('total_deduction')->nullable();
            $table->integer('net_yearly_income')->nullable();
            $table->integer('untaxable_income')->nullable();
            $table->integer('taxable_yearly_income')->nullable();
            $table->integer('income_tax_calculation_5')->nullable();
            $table->integer('income_tax_calculation_15')->nullable();
            $table->integer('income_tax_calculation_25')->nullable();
            $table->integer('income_tax_calculation_30')->nullable();
            $table->integer('yearly_income_tax')->nullable();
            $table->integer('monthly_income_tax')->nullable();
            $table->integer('basic_salary')->nullable();
            $table->integer('less')->nullable();
            $table->integer('thp')->nullable();
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
