<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnUserCuti extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_cuti', function (Blueprint $table) {
            $table->string('status', 100)->nullable();
            $table->date('join_date')->nullable();
            $table->string('length_of_service', 50)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_cuti', function (Blueprint $table) {
            //
        });
    }
}
