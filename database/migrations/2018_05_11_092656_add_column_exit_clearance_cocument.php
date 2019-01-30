<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnExitClearanceCocument extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('exit_clearance_document', function (Blueprint $table) {
            $table->integer('exit_interview_id')->nullabble();
            $table->string('keterangan_dept')->nullable();
            $table->string('keterangan_hr')->nullable();
        });

        Schema::table('exit_clearance_inventory_ga', function (Blueprint $table) {
            $table->integer('exit_interview_id')->nullabble();
            $table->string('keterangan_dept')->nullable();
            $table->string('keterangan_hr')->nullable();
        });

        Schema::table('exit_clearance_inventory_hrd', function (Blueprint $table) {
            $table->integer('exit_interview_id')->nullabble();
            $table->string('keterangan_dept')->nullable();
            $table->string('keterangan_hr')->nullable();
        });

        Schema::table('exit_clearance_inventory_it', function (Blueprint $table) {
            $table->integer('exit_interview_id')->nullabble();
            $table->string('keterangan_dept')->nullable();
            $table->string('keterangan_hr')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('exit_clearance_document', function (Blueprint $table) {
            //
        });
    }
}
