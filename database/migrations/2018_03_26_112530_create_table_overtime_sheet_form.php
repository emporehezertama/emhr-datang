<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableOvertimeSheetForm extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('overtime_sheet_form', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('overtime_sheet_id')->nullable();
            $table->date('tanggal')->nullable();
            $table->text('description')->nullable();
            $table->text('awal')->nullable();
            $table->text('akhir')->nullable();
            $table->string('total_lembur')->nullable();
            $table->integer('employee_id')->nullable();
            $table->integer('spv')->nullable();
            $table->integer('manager')->nullable();
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
        Schema::dropIfExists('overtime_sheet_form');
    }
}
