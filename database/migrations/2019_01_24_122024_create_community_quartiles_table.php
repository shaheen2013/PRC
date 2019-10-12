<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommunityQuartilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql_dev')->create('cm_community_quartiles', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('community_id')->unsigned();
            $table->unsignedSmallInteger('quartile');
            $table->integer('housing_units');
            $table->integer('est_long_term_rental')->unsigned()->nullable();
            $table->integer('est_vacant_total')->unsigned()->nullable();
            $table->integer('est_vacant_rental')->unsigned()->nullable();
            $table->integer('est_vacant_for_sale')->unsigned()->nullable();
            $table->integer('est_vacant_seasonal')->unsigned()->nullable();
            $table->integer('est_vacant_long_term')->unsigned()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('mysql_dev')->dropIfExists('cm_community_quartiles');
    }
}
