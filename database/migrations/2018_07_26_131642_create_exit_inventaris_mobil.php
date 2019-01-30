<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExitInventarisMobil extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exit_interview_inventaris_mobil', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_inventaris_mobil_id')->nullable();
            $table->smallInteger('status')->nullable();
            $table->timestamps();
        });

        Schema::create('exit_interview_inventaris', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_inventaris_id')->nullable();
            $table->smallInteger('status')->nullable();
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
        Schema::dropIfExists('exit_interview_inventaris_mobil');
    }
}
