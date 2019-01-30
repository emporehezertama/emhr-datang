<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnExitClearanceDocument extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('exit_clearance_document', function (Blueprint $table) {
            $table->dateTime('hrd_check_date')->nullable();
            $table->integer('hrd_checked')->nullable();
            $table->text('hrd_note')->nullable();
        });

        Schema::table('exit_clearance_inventory_hrd', function (Blueprint $table) {
            $table->dateTime('hrd_check_date')->nullable();
            $table->integer('hrd_checked')->nullable();
            $table->text('hrd_note')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('exit_clearance_document', function (Blueprint $table) {
            //
        });
    }
}
