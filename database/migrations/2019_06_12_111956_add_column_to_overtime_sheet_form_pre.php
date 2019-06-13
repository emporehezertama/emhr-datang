<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnToOvertimeSheetFormPre extends Migration
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
            $table->string('pre_awal_approved',10)->nullable();
            $table->string('pre_akhir_approved',10)->nullable();
            $table->string('pre_total_approved',255)->nullable();
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
