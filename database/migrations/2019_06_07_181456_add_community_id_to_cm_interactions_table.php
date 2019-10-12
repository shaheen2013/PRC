<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCommunityIdToCmInteractionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql_dev')->table('cm_interactions', function (Blueprint $table) {
            $table->integer('community_id')->nullable();
            /*$table->foreign('community_id')
                ->references('COMMUNITYID')
                ->on('osusr_mlv_community')
                ->onDelete('set null');*/
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('mysql_dev')->table('cm_interactions', function (Blueprint $table) {
            $table->dropForeign('community_id');
        });
    }
}
