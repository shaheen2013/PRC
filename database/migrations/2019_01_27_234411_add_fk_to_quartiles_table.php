<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFkToQuartilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql_dev')->table('cm_community_quartiles', function (Blueprint $table) {
//            $table->foreign('community_id')->references('COMMUNITYID')->on('osusr_mlv_community');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('mysql_dev')->table('cm_community_quartiles', function (Blueprint $table) {
            //
        });
    }
}
