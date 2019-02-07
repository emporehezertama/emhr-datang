<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnTraining extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::table('payment_request', function (Blueprint $table) {
            $table->dateTime('approve_direktur_date')->nullable();
        });

        Schema::table('training', function (Blueprint $table) {
            $table->dateTime('approve_direktur_date')->nullable();
        });

        Schema::table('cuti_karyawan', function (Blueprint $table) {
            $table->dateTime('approve_direktur_date')->nullable();
        });

        Schema::table('exit_interview', function (Blueprint $table) {
            $table->dateTime('approve_direktur_date')->nullable();
        });

        Schema::table('medical_reimbursement', function (Blueprint $table) {
            $table->dateTime('approve_direktur_date')->nullable();
        });

        Schema::table('overtime_sheet', function (Blueprint $table) {
            $table->dateTime('approve_direktur_date')->nullable();
        });

        Schema::table('training', function (Blueprint $table) {
            $table->dateTime('approve_direktur_actual_bill_date')->nullable();
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('training', function (Blueprint $table) {
            //
        });
    }
}
