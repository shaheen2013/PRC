<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommunityMiscConfigurationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql_dev')->create('cm_community_misc_configurations', function (Blueprint $table) {
            $table->integer('community_id');
            $table->primary('community_id');
            $table->foreign('community_id')
                ->references('COMMUNITYID')->on('osusr_mlv_community')
                ->onDelete('cascade');
            $table->unsignedInteger('violation_configuration')->nullable();
            $table->foreign('violation_configuration')
                ->references('id')->on('cm_violation_configurations')
                ->onDelete('set null');
            $table->boolean('utility_data')->nullable();
            $table->boolean('cm_registrations_rental')->default(false);
            $table->boolean('cm_registrations_vacant')->default(false);
            $table->boolean('cm_registrations_foreclosure')->default(false);
            $table->text('postcard_project_name')->nullable();
            $table->text('postcard_document_name')->nullable();
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
        Schema::connection('mysql_dev')->dropIfExists('cm_community_misc_configurations');
    }
}
