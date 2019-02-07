<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UserTemp extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_temp', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nik')->nullable();
            $table->string('name')->nullable();
            $table->date('join_date')->nullable();
            $table->string('gender', 20)->nullable();
            $table->string('no_bpjs_kesehatan', 100)->nullable();
            $table->string('place_of_birth')->nullable();
            $table->string('date_of_birth')->nullable();
            $table->text('id_address')->nullable();
            $table->string('id_city', 100)->nullable();
            $table->string('id_zip_code')->nullable();
            $table->string('current_address')->nullable();
            $table->string('telp')->nullable();
            $table->string('mobile_1', 25)->nullable();
            $table->string('mobile_2', 25)->nullable();
            $table->string('email', 100)->nullable();
            $table->string('blood_type')->nullable();
            // BANK
            $table->string('bank_1')->nullable();
            $table->string('bank_account_name_1')->nullable();
            $table->string('bank_account_number')->nullable();
            // ORGANISASI
            $table->string('organisasi_division')->nullable();
            $table->string('organisasi_department')->nullable();
            $table->string('organisasi_unit')->nullable();
            $table->string('organisasi_position')->nullable();
            $table->string('organisasi_position_sub')->nullable();
            $table->string('organisasi_branch')->nullable();
            $table->string('organisasi_ho_or_branch')->nullable();
            $table->string('organisasi_status')->nullable();
            // CUTI
            $table->string('cuti_join_date')->nullable();
            $table->string('cuti_length_of_service')->nullable();
            $table->string('cuti_status')->nullable();
            $table->string('cuti_cuti_2018')->nullable();
            $table->string('cuti_terpakai')->nullable();
            $table->string('cuti_sisa_cuti')->nullable();
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
        Schema::dropIfExists('users_temp');
    }
}
