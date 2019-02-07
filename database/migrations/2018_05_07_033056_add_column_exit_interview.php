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
            $table->integer('is_approved_hr_manager')->nullable();
            $table->integer('is_approved_hr_gm')->nullable();
            $table->integer('is_approved_hr_director')->nullable();
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
