<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableSettingApprovalLeaveItem extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('setting_approval_leave_item', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('setting_approval_leave_id')->nullable();
            $table->integer('setting_approval_level_id')->nullable();
            $table->integer('structure_organization_custom_id')->nullable();
            $table->text('description')->nullable();
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
        Schema::dropIfExists('setting_approval_leave_item');
    }
}
