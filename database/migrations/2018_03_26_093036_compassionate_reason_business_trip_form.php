<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CompassionateReasonBusinessTripForm extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('compassionate_reason_business_trip_form', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('compassionate_reason_business_trip')->nullable();
            $table->date('tanggal')->nullable();
            $table->date('from_date')->nullable();
            $table->date('hingga_date')->nullable();
            $table->text('reason')->nullable();
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
        Schema::dropIfExists('compassionate_reason_business_trip_form');
    }
}
