<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContractsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql_dev')->create('cm_contracts', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('community_id');
//            $table->foreign('community_id')
//                ->references('COMMUNITYID')->on('osusr_mlv_community')
//                ->onDelete('cascade');
            $table->text('programs');
            $table->boolean('rental')->default(false);
            $table->boolean('vacant')->default(false);
            $table->boolean('foreclosure')->default(false);
            $table->date('start_date');
            $table->integer('number_of_terms');
            $table->integer('term_length');
            $table->boolean('auto_renewal');
            $table->date('expiration_date')->nullable();
            $table->boolean('assignment');
            $table->boolean('consent_required');
            $table->boolean('survival')->nullable();
            $table->longText('description')->nullable();
            $table->boolean('notice_required');
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
        Schema::connection('mysql_dev')->dropIfExists('cm_contracts');
    }
}
