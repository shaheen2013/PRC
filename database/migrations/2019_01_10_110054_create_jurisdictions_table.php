<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJurisdictionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jurisdictions', function (Blueprint $table) {
            $table->increments('id');
            $table->decimal('ordinance_amount')->nullable();
            $table->dateTime('ordinance_pass_date')->nullable();
            $table->integer('renewal_policy')->nullable();
            $table->boolean('active')->default(false)->nullable();
            $table->boolean('local_agent_service')->default(false)->nullable();
            $table->integer('community_org')->unsigned()->nullable();
//            $table->foreign('community_org')->references('id')->on('organizations');
            $table->dateTime('matched_owner_name_date')->nullable();
            $table->dateTime('clerk_event_date')->nullable();
            $table->dateTime('sale_event_date')->nullable();
            $table->boolean('private_owner_registration')->nullable();
            $table->integer('private_renewal_policy')->nullable();
            $table->integer('private_occupancy_policy')->nullable();
            $table->boolean('delist_loan_bc')->default(false)->nullable();
            $table->boolean('delist_loan_paid_off')->default(false)->nullable();
            $table->boolean('delist_loan_m')->default(false)->nullable();
            $table->boolean('delist_sale_third_party')->default(false)->nullable();
            $table->boolean('delist_sale_loan')->default(false)->nullable();
            $table->boolean('delist_sale_of_servicing')->default(false)->nullable();
            $table->boolean('delist_occupancy')->default(false)->nullable();
            $table->boolean('delist_bank_owned')->default(false)->nullable();
            $table->boolean('delist_other')->default(false)->nullable();
            $table->integer('community_id')->unsigned();
//            $table->foreign('community_id')->references('id')->on('communities');
            $table->dateTime('active_date')->nullable();
            $table->boolean('active_for_registrations')->nullable();
            $table->dateTime('active_for_registrations_date')->nullable();
            $table->boolean('active_vacant_registration')->nullable();
            $table->dateTime('active_vacant_registration_date')->nullable();
            $table->boolean('active_rental_registration')->nullable();
            $table->dateTime('active_rental_registration_date')->nullable();
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
        Schema::dropIfExists('jurisdictions');
    }
}
