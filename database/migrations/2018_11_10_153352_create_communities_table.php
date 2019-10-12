<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommunitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('communities', function (Blueprint $table) {
            $table->integer('id')->unsigned()->unique();
            $table->primary('id');
            $table->string('state', 2)->nullable();
            $table->string('county', 100)->nullable();
            $table->string('city', 100)->nullable();
            $table->string('group_email', 250)->nullable();
            $table->integer('community_status_id')->nullable();
            $table->integer('community_vacant_status_id')->nullable();
            $table->integer('community_rental_status_id')->nullable();
            $table->integer('community_vacation_status_id')->nullable();
            $table->string('code', 250)->nullable();
            $table->boolean('multiple_communities')->nullable();
            $table->bigInteger('ordinance_id')->nullable();
            $table->integer('rental_ordinance_id')->nullable();
            $table->longText('zipcodes')->nullable();
            $table->string('friendly_name')->nullable();
            $table->string('full_name')->nullable();
            $table->string('notes', 1500)->nullable();
            $table->boolean('no_juris_flag')->nullable();
            $table->integer('primary_community_id')->nullable();
            $table->boolean('related_county')->nullable();
            $table->dateTime('rental_updated_date')->nullable();
            $table->dateTime('status_change_date')->nullable();
            $table->integer('order')->nullable();
            $table->bigInteger('running_ordinance_id')->nullable();
            $table->integer('running_community_status_id')->nullable();
            $table->integer('running_rental_ordinance_id')->nullable();
            $table->integer('running_community_rental_status')->nullable();
            $table->boolean('enforced_delinquent')->nullable();
            $table->boolean('ic_flag')->nullable();
            $table->boolean('specific_map_service')->nullable();
            $table->boolean('integrated_violations')->nullable();
            $table->boolean('integrated_leins')->nullable();
            $table->integer('days_to_close_violations')->nullable();
            $table->boolean('no_unincf_flag')->nullable();
            $table->bigInteger('approved_forclosure_id')->nullable();
            $table->integer('approved_forclosure_status_id')->nullable();
            $table->bigInteger('pending_forclosure_id')->nullable();
            $table->integer('pending_forclosure_status_id')->nullable();
            $table->boolean('had_renewal_type_changes')->nullable();

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
        Schema::dropIfExists('communities');
    }
}
