<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnPaymentRequest extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('payment_request', function (Blueprint $table) {
            $table->smallInteger('proposal_approval_approved')->nullable();
            $table->dateTime('proposal_approval_date')->nullable();
            $table->integer('proposal_approval_id')->nullable();

            $table->smallInteger('proposal_verification_approved')->nullable();
            $table->dateTime('proposal_verification_date')->nullable();
            $table->integer('proposal_verification_id')->nullable();

            $table->smallInteger('payment_approval_approved')->nullable();
            $table->dateTime('payment_approval_date')->nullable();
            $table->integer('payment_approval_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('payment_request', function (Blueprint $table) {
            //
        });
    }
}
