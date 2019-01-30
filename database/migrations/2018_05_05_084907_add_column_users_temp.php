<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnUsersTemp extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users_temp', function (Blueprint $table) {
            $table->integer('directorate_id')->nullable();
            $table->integer('ldap')->nullable();
            $table->string('ktp_number', 100)->nullable();
            $table->string('passport_number', 100)->nullable();
            $table->string('kk_number', 100)->nullable();
            $table->string('npwp_number', 100)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users_temp', function (Blueprint $table) {
            //
        });
    }
}
