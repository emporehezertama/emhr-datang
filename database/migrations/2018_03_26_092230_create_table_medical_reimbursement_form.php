<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableMedicalReimbursementForm extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('medical_reimbursement_form', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('medical_reimbursement_id')->nullable();
            $table->date('tanggal_kwitansi')->nullable();
            $table->integer('pasien_id')->nullable();
            $table->string('jenis_klaim')->nullable();
            $table->text('keterangan')->nullable();
            $table->integer('jumlah');
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
        Schema::dropIfExists('medical_reimbursement_form');
    }
}
