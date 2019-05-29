<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrainingTransportationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('training_transportation', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('training_id');
            $table->date('date');
            $table->integer('training_transportation_type_id')->nullable();
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
        Schema::dropIfExists('training_transportation');
    }
}
