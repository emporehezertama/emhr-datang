<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnToOvertimeSheetForm extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('overtime_sheet_form', function (Blueprint $table) {
            //
            $table->string('awal_claim',10)->nullable();
            $table->string('akhir_claim',10)->nullable();
            $table->string('total_lembur_claim',255)->nullable();
            $table->string('awal_approved',10)->nullable();
            $table->string('akhir_approved',10)->nullable();
            $table->string('total_lembur_approved',255)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('overtime_sheet_form', function (Blueprint $table) {
            //
        });
    }
}
