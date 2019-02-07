<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnTableUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('ldap')->nullable();
            $table->integer('division_id')->nullable();
            $table->integer('position_level_id')->nullable();
            $table->integer('work_location_id')->nullable();
            $table->string('supervisor_1_level_nik')->nullable();
            $table->string('supervisor_2_level_nik')->nullable();
            $table->string('ext')->nullable();
            $table->string('handphone')->nullable();
            $table->string('ktp_number')->nullable();
            $table->string('passport_number')->nullable();
            $table->string('kitas_number')->nullable();
            $table->string('kk_number')->nullable();
            $table->string('npw_number')->nullable();
            $table->string('jamsostek_number')->nullable();
            $table->string('bpjs_number')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('bank_branch')->nullable();
            $table->string('bank_account_number')->nullable();
            $table->integer('address_as_of_id')->nullable();
            $table->integer('city_as_of_id')->nullable();
            $table->integer('province_as_of_id')->nullable();
            $table->integer('zip_as_of_id')->nullable();
            $table->integer('country_as_of_id')->nullable();
            $table->text('home_address')->nullable();
            $table->integer('home_city')->nullable();
            $table->integer('home_province')->nullable();
            $table->integer('home_zip')->nullable();
            $table->integer('home_country')->nullable();
            $table->string('home_phone_number')->nullable();
            $table->integer('nationality_id')->nullabel();
            $table->integer('marital_status')->nullable();
            $table->string('spouse_name')->nullable();
            $table->string('spouse_nik')->nullable();
            $table->string('spouse_bpjs_number')->nullable();
            $table->string('children_1_name')->nullable();
            $table->string('children_1_nik')->nullable();
            $table->string('children_1_bpjs_number')->nullable();

            $table->string('children_2_name')->nullable();
            $table->string('children_2_nik')->nullable();
            $table->string('children_2_bpjs_number')->nullable();

            $table->string('children_3_name')->nullable();
            $table->string('children_3_nik')->nullable();
            $table->string('children_3_bpjs_number')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
}
