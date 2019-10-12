<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRfpStatusAndKpaToSalesConfigurationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql_dev')->table('cm_community_sales_configurations', function (Blueprint $table) {
            $table->boolean('rfp_status')->default(false);
            $table->boolean('key_policy_agreement')->default(false);
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
            $table->dropColumn('rfp_status');
            $table->dropColumn('key_policy_agreement');
        });
    }
}
