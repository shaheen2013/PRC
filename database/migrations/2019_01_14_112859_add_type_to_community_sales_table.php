<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTypeToCommunitySalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('community_sales', function (Blueprint $table) {
            $table->integer('program_type')->unsigned();
            $table->foreign('program_type')->references('id')->on('program_types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('community_sales', function (Blueprint $table) {
            $table->dropColumn('program_type');
        });
    }
}
