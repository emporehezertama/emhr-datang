<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnToHistoryApprovalOvertime extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('history_approval_overtime', function (Blueprint $table) {
            //
            $table->integer('approval_id_claim')->nullable();
            $table->integer('is_approved_claim')->nullable();
            $table->datetime('date_approved_claim')->nullable();
            $table->text('note_claim')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('history_approval_overtime', function (Blueprint $table) {
            //
        });
    }
}
