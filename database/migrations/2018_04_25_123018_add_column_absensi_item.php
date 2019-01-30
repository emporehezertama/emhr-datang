<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnAbsensiItem extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('absensi_item', function (Blueprint $table) {
            $table->string('ndays')->nullable();
            $table->string('weekend')->nullable();
            $table->string('holiday')->nullable();
            $table->string('att_time')->nullable();
            $table->string('ndays_ot')->nullable();
            $table->string('weekend_ot')->nullable();
            $table->string('holiday_ot')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('absensi_item', function (Blueprint $table) {
            //
        });
    }
}
