<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrainingAllowancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('training_allowance', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('training_id');
            $table->date('date');
            $table->integer('meal_plafond')->nullable();
            $table->integer('morning')->nullable();
            $table->integer('morning_approved')->nullable();
            $table->integer('afternoon')->nullable();
            $table->integer('afternoon_approved')->nullable();
            $table->integer('evening')->nullable();
            $table->integer('evening_approved')->nullable();
            $table->text('note')->nullable();
            $table->text('file_struk')->nullable();
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
        Schema::dropIfExists('training_allowance');
    }
}
