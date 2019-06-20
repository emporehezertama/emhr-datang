<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCrmModulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('crm_module', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('project_id')->nullable();
            $table->string('project_name')->nullable();
            $table->string('client_name')->nullable();
            $table->string('user_name')->nullable();
            $table->string('password')->nullable();
            $table->integer('crm_product_id')->nullable();
            $table->integer('limit_user')->nullable();
            $table->string('modul_name')->nullable();
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
        Schema::dropIfExists('crm_module');
    }
}
