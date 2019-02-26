<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTablePayrollEarningsEmployee extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payroll_earnings_employee', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('payroll_id')->nullable();
            $table->integer('payroll_earning_id')->nullable();
            $table->integer('nominal')->nullable();
            $table->timestamps();
        });

        Schema::create('payroll_deductions_employee', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('payroll_id')->nullable();
            $table->integer('payroll_deduction_id')->nullable();
            $table->integer('nominal')->nullable();
            $table->timestamps();
        });

        Schema::create('payroll_earnings_employee_history', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('payroll_id')->nullable();
            $table->integer('payroll_earning_id')->nullable();
            $table->integer('nominal')->nullable();
            $table->timestamps();
        });

        Schema::create('payroll_deductions_employee_history', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('payroll_id')->nullable();
            $table->integer('payroll_deduction_id')->nullable();
            $table->integer('nominal')->nullable();
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
        Schema::dropIfExists('payroll_earnings_employee');
    }
}
