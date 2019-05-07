<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnToExitInterviewAssets extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('exit_interview_assets', function (Blueprint $table) {
            //
             $table->integer('user_check')->nullable();
             $table->integer('approval_check')->nullable();
             $table->integer('approval_id')->nullable();
             $table->datetime('date_approved')->nullable();
                
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('exit_interview_assets', function (Blueprint $table) {
            //
        });
    }
}
