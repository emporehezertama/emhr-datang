<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableAbsensiDevice extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('absensi_device', function (Blueprint $table) {
            $table->increments('id');
            $table->string('sn')->nullable();
            $table->string('state')->nullable();
            $table->string('last_activity')->nullable();
            $table->string('trans_times')->nullable();
            $table->string('trans_interval')->nullable();
            $table->string('alias')->nullable();
            $table->string('style')->nullable();
            $table->string('version')->nullable();
            $table->string('fp_count')->nullable();
            $table->string('transaction_count')->nullable();
            $table->string('user_count')->nullable();
            $table->string('main_time')->nullable();
            $table->string('max_finger_count')->nullable();
            $table->string('max_att_log_count')->nullable();
            $table->string('device_name')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('absensi_item');
    }
}
