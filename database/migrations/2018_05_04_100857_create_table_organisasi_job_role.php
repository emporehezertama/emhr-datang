<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableOrganisasiJobRole extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('organisasi_job_role', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('organisasi_division_id')->nullable();
            $table->integer('organisasi_department_id')->nullable();
            $table->integer('organisasi_unit_id')->nullable();
            $table->integer('organisasi_position_id')->nullable();
            $table->string('name')->nullable();
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
        Schema::dropIfExists('organisasi_job_role');
    }
}
