<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSalesActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql_dev')->create('cm_sales_activities', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('community_id');
            /*$table->foreign('community_id')
                ->references('COMMUNITYID')->on('osusr_mlv_community')
                ->onDelete('cascade');*/
            $table->integer('sales_cycle_id')->unsigned();
            /*$table->foreign('sales_cycle_id')
                ->references('id')->on('cm_sales_cycles')
                ->onDelete('cascade');*/
            $table->integer('contact_id')->unsigned();
            /*$table->foreign('contact_id')
                ->references('id')->on('cm_contacts')
                ->onDelete('cascade');*/
            $table->tinyInteger('deal_type');
            $table->text('subject');
            $table->longText('body');
            $table->date('activity_date');
            $table->date('target_close_date');
            $table->tinyInteger('sales_stage');

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
        Schema::connection('mysql_dev')->dropIfExists('cm_sales_activities');
    }
}
