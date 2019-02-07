<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAssetTracking extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('asset_tracking', function (Blueprint $table) {
            $table->increments('id');
            $table->string('asset_number', 10)->nullable();
            $table->string('asset_name')->nullable();
            $table->integer('asset_type_id')->nullable();
            $table->string('asset_sn', 100)->nullable();
            $table->date('purchase_date')->nullable();
            $table->string('asset_condition', 100)->nullable();
            $table->string('assign_to', 25)->nullable();
            $table->integer('user_id')->nullable();
            $table->dateTime('handover_date')->nullable();
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
        Schema::dropIfExists('asset_tracking');
    }
}
