<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnStructureOrganizationCustom557 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('structure_organization_custom', function (Blueprint $table) {
            $table->integer('organisasi_division_id')->nullable();
            $table->integer('organisasi_position_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('structure_organization_custom', function (Blueprint $table) {
            //
        });
    }
}
