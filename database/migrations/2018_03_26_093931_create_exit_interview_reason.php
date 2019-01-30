<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExitInterviewReason extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exit_interview_reason', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('is_parent')->nullable();
            $table->string('parent_label')->nullable();
            $table->integer('parent_id')->nullable();
            $table->text('label')->nullable();
            $table->string('type')->nullable();
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
        Schema::dropIfExists('exit_interview_reason');
    }
}
