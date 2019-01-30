<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnExitClearanceInventoryGa extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('exit_clearance_inventory_ga', function (Blueprint $table) {
            $table->dateTime('ga_check_date')->nullable();
            $table->integer('ga_checked')->nullable();
            $table->text('ga_note')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('exit_clearance_inventory_ga', function (Blueprint $table) {
            //
        });
    }
}
