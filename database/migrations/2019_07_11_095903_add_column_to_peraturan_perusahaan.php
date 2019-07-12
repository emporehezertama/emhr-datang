<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnToPeraturanPerusahaan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('peraturan_perusahaan', function (Blueprint $table) {
            //
            $table->integer('status')->nullable();
            $table->text('content')->nullable();
            $table->text('image')->nullable();
            $table->text('thumbnail')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('peraturan_perusahaan', function (Blueprint $table) {
            //
        });
    }
}
