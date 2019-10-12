<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommunityRmTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql_dev')->create('cm_community_rm', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('community_id')->nullable();
            /*$table->foreign('community_id')
                ->references('COMMUNITYID')
                ->on('osusr_mlv_community')
                ->onDelete('cascade');*/
            $table->integer('relationship_manager_id')->unsigned();
            /*$table->foreign('relationship_manager_id')
                ->references('id')
                ->on('cm_relationship_managers')
                ->onDelete('cascade');*/
            $table->integer('legacy_id')->nullable();
            $table->integer('county_id')->nullable();
            $table->boolean('secondary_rm')->default(false);
            $table->decimal('rm_amount', 37, 8);
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
        Schema::connection('mysql_dev')->dropIfExists('cm_community_rm');
    }
}
