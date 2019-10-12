<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRemittanceEmailRequiredToSalesConfigurationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql_dev')->table('cm_community_sales_configurations', function (Blueprint $table) {
            $table->boolean('remittance_email_required')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('mysql_dev')->table('cm_community_sales_configurations', function (Blueprint $table) {
            $table->dropColumn('remittance_email_required');
        });
    }
}
