<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnExitClearanceInventoryIt extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('exit_clearance_inventory_it', function (Blueprint $table) {
            $table->smallInteger('it_checked')->nullabel();
            $table->dateTime('it_checked_date')->nullabel();
            $table->text('it_checked_note')->nullabel();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('exit_clearance_inventory_it', function (Blueprint $table) {
            //
        });
    }
}
