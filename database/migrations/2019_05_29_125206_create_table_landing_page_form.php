<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableLandingPageForm extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('landing_page_form', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nama', 100)->nullable();
            $table->string('jabatan', 50)->nullable();
            $table->string('email', 100)->nullable();
            $table->string('password', 150)->nullable();
            $table->string('perusahaan', 100)->nullable();
            $table->string('bidang_usaha', 100)->nullable();
            $table->string('handphone', 50)->nullable();
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
        Schema::dropIfExists('landing_page_form');
    }
}
