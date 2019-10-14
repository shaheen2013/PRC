<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSalesCyclesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql_dev')->create('cm_sales_cycles', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('community_id');
            $table->foreign('community_id')
                ->references('COMMUNITYID')->on('osusr_mlv_community')
                ->onDelete('cascade');
            $table->string('name');
            $table->text('programs');
            $table->boolean('rental')->default(false);
            $table->boolean('vacant')->default(false);
            $table->boolean('foreclosure')->default(false);
            $table->integer('contact_id')->unsigned();
            $table->foreign('contact_id')
                ->references('id')->on('cm_contacts')
                ->onDelete('cascade');
            $table->tinyInteger('deal_type');
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
        Schema::connection('mysql_dev')->dropIfExists('cm_sales_cycles');
    }
}
