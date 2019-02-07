<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnExitInterview extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('exit_interview', function (Blueprint $table) {
            $table->integer('is_approved_atasan')->nullable();
            $table->integer('approved_atasan_id')->nullable();
            $table->dateTime('date_approved_atasan')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('exit_interview', function (Blueprint $table) {
            //
        });
    }
}
