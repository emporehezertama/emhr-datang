<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnOvertimeSheet extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('overtime_sheet', function (Blueprint $table) {
            $table->integer('is_approved_atasan')->nullable();
            $table->dateTime('date_approved_atasan')->nullable();
            $table->integer('approved_atasan_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('overtime_sheet', function (Blueprint $table) {
            //
        });
    }
}
