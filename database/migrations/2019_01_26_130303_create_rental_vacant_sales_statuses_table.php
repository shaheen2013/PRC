<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRentalVacantSalesStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql_dev')->create('cm_rental_vacant_sales_statuses', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('community_id');
//            $table->foreign('community_id')->references('COMMUNITYID')->on('osusr_mlv_community');
            $table->integer('vacant_status')->default(1);
//            $table->foreign('vacant_status')->references('ID')->on('osusr_tvl_salesstatus');
            $table->integer('rental_status')->default(1);
//            $table->foreign('rental_status')->references('ID')->on('osusr_tvl_salesstatus');
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
        Schema::connection('mysql_dev')->dropIfExists('cm_rental_vacant_sales_statuses');
    }
}
