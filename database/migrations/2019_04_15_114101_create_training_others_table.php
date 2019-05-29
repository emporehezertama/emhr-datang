<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrainingOthersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('training_other', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('training_id');
            $table->date('date');
            $table->text('description')->nullable();
            $table->integer('nominal')->nullable();
            $table->integer('nominal_approved')->nullable();
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
        Schema::dropIfExists('training_other');
    }
}
