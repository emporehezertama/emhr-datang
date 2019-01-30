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
        Schema::table('exit_clearance', function (Blueprint $table) {
            $table->string('inventory_it_username_pc')->nullable();
            $table->string('inventory_it_password_pc')->nullable();
            $table->string('inventory_it_email')->nullable();
            $table->string('inventory_it_username_arium')->nullable();
            $table->string('inventory_it_password_arium')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('exit_clearance', function (Blueprint $table) {
            //
        });
    }
}
