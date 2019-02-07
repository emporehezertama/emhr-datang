<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnInventaris extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('exit_interview_inventaris', function (Blueprint $table) {
            $table->integer('exit_interview_id')->nullable();
        });

        Schema::table('exit_interview_inventaris_mobil', function (Blueprint $table) {
            $table->integer('exit_interview_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('exit_interview_inventaris', function (Blueprint $table) {
            //
        });
    }
}
