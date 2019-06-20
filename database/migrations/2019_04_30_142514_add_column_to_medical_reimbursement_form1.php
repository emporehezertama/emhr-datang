<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnToMedicalReimbursementForm1 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('medical_reimbursement_form', function (Blueprint $table) {
            //
            $table->integer('kuota_plafond');
            $table->integer('plafond_terpakai');
            $table->integer('plafond_sisa');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('medical_reimbursement_form', function (Blueprint $table) {
            //
        });
    }
}
