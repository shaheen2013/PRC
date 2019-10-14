<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRelationshipManagersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql_dev')->create('cm_relationship_managers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('organization_id')->nullable();
            $table->foreign('organization_id')->references('id')->on('osusr_rjr_organization')->onDelete('set null');
            $table->string('email')->nullable();
            $table->string('name')->nullable();
            $table->string('street')->nullable();
            $table->string('phone')->nullable();
            $table->string('zip')->nullable();
            $table->string('state')->nullable();
            $table->string('city')->nullable();
            $table->string('website')->nullable();
            $table->string('note', 1500)->nullable();
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
        Schema::connection('mysql_dev')->dropIfExists('cm_relationship_managers');
    }
}
