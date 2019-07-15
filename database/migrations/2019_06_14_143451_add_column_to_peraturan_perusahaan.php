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
            $table->integer('user_created')->nullable();
            $table->integer('status')->nullable()->after('title');
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
