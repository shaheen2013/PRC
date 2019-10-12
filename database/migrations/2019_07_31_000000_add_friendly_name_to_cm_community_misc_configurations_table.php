<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFriendlyNameToCmCommunityMiscConfigurationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql_dev')->table('cm_community_misc_configurations', function (Blueprint $table) {
            $table->text('custom_friendly_name')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('mysql_dev')->table('cm_community_misc_configurations', function (Blueprint $table) {
            $table->dropColumn('custom_friendly_name');
        });
    }
}
