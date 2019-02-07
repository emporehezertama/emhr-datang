<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentRequestForm extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_request_form', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('payment_request_id')->nullable();
            $table->text('description')->nullable();
            $table->integer('quantity')->nullable();
            $table->integer('estimation_cost')->nullable();
            $table->integer('amount')->nullable();
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
        Schema::dropIfExists('payment_request_form');
    }
}
