<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPartnerStatusToCmRentalVacantSalesStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql_dev')->table('cm_rental_vacant_sales_statuses', function (Blueprint $table) {
            $table->boolean('rental_partner_status')->nullable();
            $table->boolean('vacant_partner_status')->nullable();
            $table->boolean('foreclosure_partner_status')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('mysql_dev')->table('cm_rental_vacant_sales_statuses', function (Blueprint $table) {
            $table->dropColumn('rental_partner_status');
            $table->dropColumn('vacant_partner_status');
            $table->dropColumn('foreclosure_partner_status');
        });
    }
}
