<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRelationshipStatusNotesToCommunitySalesConfigurationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql_dev')->table('cm_community_sales_configurations', function (Blueprint $table) {
            $table->text('relationship_status_notes')->after('relationship_status')->nullable();
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
            $table->dropColumn('relationship_status_notes');
        });
    }
}
