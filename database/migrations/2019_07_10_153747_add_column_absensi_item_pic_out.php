<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnAbsensiItemPicOut extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('absensi_item', function (Blueprint $table) {
            $table->text('pic_out')->nullable();
            $table->string('long_out', 255)->nullable();
            $table->string('lat_out', 255)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('absensi_item', function (Blueprint $table) {
            //
        });
    }
}
