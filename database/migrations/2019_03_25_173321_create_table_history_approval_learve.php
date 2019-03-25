<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableHistoryApprovalLearve extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('history_approval_leave', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('cuti_karyawan_id')->nullable();
            $table->integer('structure_organization_custom_id')->nullable();
            $table->integer('setting_approval_level_id')->nullable();
            $table->integer('approval_id')->nullable();
            $table->boolean('is_approved')->nullable();
            $table->date('date_approved')->nullable();
            $table->text('note')->nullable();
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
        Schema::dropIfExists('history_approval_leave');
    }
}
