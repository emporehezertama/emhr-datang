<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnMedicalReimbursement extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('medical_reimbursement', function (Blueprint $table) {
            $table->integer('is_approved_hr_benefit')->nullable();
            $table->integer('is_approved_manager_hr')->nullable();
            $table->integer('is_approved_gm_hr')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('medical_reimbursement', function (Blueprint $table) {
            //
        });
    }
}
