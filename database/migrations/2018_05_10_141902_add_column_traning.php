<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnTraning extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('training', function (Blueprint $table) {
            $table->integer('is_approve_atasan_actual_bill')->nullable();
            $table->integer('is_approve_hrd_actual_bill')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('training', function (Blueprint $table) {
            //
        });
    }
}
