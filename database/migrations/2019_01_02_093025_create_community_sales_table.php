<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommunitySalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('community_sales', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('community_id')->unsigned()->unique();
//            $table->foreign('community_id')->references('id')->on('communities');
            $table->integer('sales_status_id')->unsigned()->unique();
//            $table->foreign('sales_status_id')->references('id')->on('sales_statuses');
            $table->dateTime('engaged_date');
            $table->dateTime('onboarding_future_date');
            $table->dateTime('partner_date');
            $table->decimal('ccc_amount', 37, 8);
            $table->integer('remittance_period');
            $table->dateTime('contract_effective_date');
            $table->dateTime('contract_expiration_date');
            $table->boolean('survival_provision');
            $table->integer('contract_attachment');
            $table->longText('contract_term');
            $table->integer('last_updated_by');
            $table->string('none_notes', 1500);
            $table->boolean('ordinance_already_passed');
            $table->integer('registration_fee');
            $table->boolean('remittance_edit_locked');
            $table->boolean('rm_no_value_defined');
            $table->boolean('onboarding');
            $table->dateTime('onboarding_target_date');
            $table->boolean('ordinance_check');
            $table->boolean('contract_check');
            $table->boolean('data_check');
            $table->boolean('cm_registrations_check');
            $table->string('notes', 2000);
            $table->dateTime('prospect_date');
            $table->dateTime('target_1_date');
            $table->dateTime('no_interest_date');
            $table->dateTime('target_2_date');
            $table->dateTime('target_3_date');
            $table->dateTime('target_date_end');
            $table->string('hubspot_deal_id');
            $table->integer('sharepoint_doc');
            $table->integer('sharepoint_doc_id');
            $table->string('sharepoint_doc_name', 250);
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
        Schema::dropIfExists('community_sales');
    }
}
