<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnAsset extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('asset', function (Blueprint $table) {
            $table->string('remark')->nullable();
            $table->date('rental_date')->nullable();
            $table->string('tipe_mobil', 200)->nullable();
            $table->string('tahun', 5)->nullable();
            $table->string('no_polisi', 25)->nullable();
            $table->string('status_mobil', 25)->nullable();
        });

        Schema::table('asset_tracking', function (Blueprint $table) {
            $table->string('remark')->nullable();
            $table->date('rental_date')->nullable();
            $table->string('tipe_mobil', 200)->nullable();
            $table->string('tahun', 5)->nullable();
            $table->string('no_polisi', 25)->nullable();
            $table->string('status_mobil', 25)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('asset', function (Blueprint $table) {
            //
        });
    }
}
