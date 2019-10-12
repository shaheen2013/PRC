<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTypeToOrganizationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('organizations', function (Blueprint $table) {
            $table->integer('type')->unsigned()->nullable();
//            $table->foreign('type')->references('id')->on('organization_types');
            $table->integer('default_jurisdiction')->unsigned()->nullable();
//            $table->foreign('default_jurisdiction')->references('id')->on('jurisdictions');
            $table->boolean('confirmed')->default(false);
            $table->boolean('all_communities')->default(false);
            $table->boolean('archived')->default(false);
            $table->boolean('weekly_notification')->default(false);
            $table->boolean('is_trustee')->default(false);
            $table->boolean('extended_registration_export')->default(false);
            $table->dateTime('role_omt_date')->nullable();
            $table->dateTime('role_ams_date')->nullable();
            $table->integer('role_omt_status')->unsigned()->nullable();
//            $table->foreign('role_omt_status')->references('id')->on('organization_role_statuses');
            $table->integer('role_ams_status')->unsigned()->nullable();
//            $table->foreign('role_ams_status')->references('id')->on('organization_role_statuses');
            $table->dateTime('role_omt_confirmed_date')->nullable();
            $table->dateTime('role_ams_confirmed_date')->nullable();
            $table->integer('role_omt_approved_by')->unsigned()->nullable();
//            $table->foreign('role_omt_approved_by')->references('id')->on('contacts');
            $table->integer('role_ams_approved_by')->unsigned()->nullable();
//            $table->foreign('role_ams_approved_by')->references('id')->on('contacts');
            $table->boolean('onboarded')->default(false);
            $table->integer('onboarded_by')->unsigned()->nullable();
//            $table->foreign('onboarded_by')->references('id')->on('contacts');
            $table->integer('parent_org')->unsigned()->nullable();
            $table->boolean('locked_contacts')->default(false);
            $table->boolean('keyrg')->default(false);
            $table->decimal('dpp_limit')->nullable();
            $table->boolean('government_entity')->default(false);
            $table->integer('role_omt_rg_assigned')->nullable();
            $table->decimal('invoice_limit')->nullable();
            $table->boolean('block_notifications')->default(false);
            $table->dateTime('block_notifications_at')->nullable();
            $table->integer('block_notifications_updated_by')->unsigned()->nullable();
//            $table->foreign('block_notifications_updated_by')->references('id')->on('contacts');
            $table->boolean('tax_lien_purchaser')->default(false);
            $table->boolean('is_offline_org_rp_initiative_chat')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('organizations', function (Blueprint $table) {
        });
    }
}
