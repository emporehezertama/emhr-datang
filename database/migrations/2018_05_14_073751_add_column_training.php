<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnTraining extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('training', function (Blueprint $table) {
            $table->smallInteger('approved_hrd')->nullable();
            $table->integer('approved_hrd_id')->nullable();
            $table->dateTime('approved_hrd_date')->nullable();

            $table->smallInteger('approved_finance')->nullable();
            $table->integer('approved_finance_id')->nullable();
            $table->dateTime('approved_finance_date')->nullable();
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
