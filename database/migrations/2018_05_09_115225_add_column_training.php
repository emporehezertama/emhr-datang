<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnTraining extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('training', function (Blueprint $table) {
            $table->integer('transportasi_ticket_disetujui')->nullable();
            $table->text('transportasi_ticket_file')->nullable();
            $table->text('transportasi_ticket_catatan')->nullable();

            $table->integer('transportasi_taxi_disetujui')->nullable();
            $table->text('transportasi_taxi_file')->nullable();
            $table->text('transportasi_taxi_catatan')->nullable();

            $table->integer('transportasi_gasoline_disetujui')->nullable();
            $table->text('transportasi_gasoline_file')->nullable();
            $table->text('transportasi_gasoline_catatan')->nullable();

            $table->integer('transportasi_tol_disetujui')->nullable();
            $table->text('transportasi_tol_file')->nullable();
            $table->text('transportasi_tol_catatan')->nullable();

            $table->integer('transportasi_parkir_disetujui')->nullable();
            $table->text('transportasi_parkir_file')->nullable();
            $table->text('transportasi_parkir_catatan')->nullable();

            $table->integer('uang_hotel_plafond')->nullable();            
            $table->integer('uang_hotel_nominal')->nullable();            
            $table->integer('uang_hotel_qty')->nullable();            
            $table->integer('uang_hotel_nominal_disetujui')->nullable();            
            $table->text('uang_hotel_file')->nullable();            
            $table->text('uang_hotel_catatan')->nullable();

            $table->integer('uang_makan_plafond')->nullable();            
            $table->integer('uang_makan_nominal')->nullable();            
            $table->integer('uang_makan_qty')->nullable();            
            $table->integer('uang_makan_nominal_disetujui')->nullable();            
            $table->text('uang_makan_file')->nullable();            
            $table->text('uang_makan_catatan')->nullable();

            $table->integer('uang_harian_plafond')->nullable();            
            $table->integer('uang_harian_nominal')->nullable();            
            $table->integer('uang_harian_qty')->nullable();            
            $table->integer('uang_harian_nominal_disetujui')->nullable();            
            $table->text('uang_harian_file')->nullable();            
            $table->text('uang_harian_catatan')->nullable();            
            
            $table->integer('uang_pesawat_plafond')->nullable();            
            $table->integer('uang_pesawat_nominal')->nullable();            
            $table->integer('uang_pesawat_qty')->nullable();            
            $table->integer('uang_pesawat_nominal_disetujui')->nullable();            
            $table->text('uang_pesawat_file')->nullable();            
            $table->text('uang_pesawat_catatan')->nullable();

            $table->integer('uang_biaya_lainnya1')->nullable();            
            $table->integer('uang_biaya_lainnya1_nominal')->nullable();            
            $table->integer('uang_biaya_lainnya1_nominal_disetujui')->nullable();            
            $table->text('uang_biaya_lainnya1_file')->nullable();            
            $table->text('uang_biaya_lainnya1_catatan')->nullable();

            $table->integer('uang_biaya_lainnya2')->nullable();            
            $table->integer('uang_biaya_lainnya2_nominal')->nullable();            
            $table->integer('uang_biaya_lainnya3_nominal_disetujui')->nullable();            
            $table->text('uang_biaya_lainnya2_file')->nullable();            
            $table->text('uang_biaya_lainnya2_catatan')->nullable(); 

            $table->integer('status_actual_bill')->nullable();           

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('training', function (Blueprint $table) {
            //
        });
    }
}
