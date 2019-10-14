<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommunitySalesConfigurationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql_dev')->create('cm_community_sales_configurations', function (Blueprint $table) {
            $table->integer('community_id');
            $table->primary('community_id');
            $table->foreign('community_id')
                ->references('COMMUNITYID')->on('osusr_mlv_community')
                ->onDelete('cascade');
            $table->integer('sales_status')->nullable();
            $table->unsignedInteger('relationship_status')->nullable();
            $table->foreign('relationship_status')
                ->references('id')->on('cm_relationship_statuses')
                ->onDelete('set null');
            $table->boolean('home_rule')->nullable();
            $table->unsignedInteger('opt_in_status')->nullable();
            $table->foreign('opt_in_status')
                ->references('id')->on('cm_opt_in_statuses')
                ->onDelete('set null');
            $table->boolean('special_oversight')->nullable();
            $table->text('special_oversight_notes')->nullable();
            $table->boolean('strong_mayor')->nullable();
            $table->longText('mayor_notes')->nullable();

            $table->unsignedInteger('state_foreclosure_process')->nullable();
            $table->foreign('state_foreclosure_process', 'sfp')
                ->references('id')->on('cm_state_foreclosure_process_configs')
                ->onDelete('set null');
            $table->unsignedInteger('state_governance')->nullable();
            $table->foreign('state_governance')
                ->references('id')->on('cm_state_governance_options')
                ->onDelete('set null');
            $table->boolean('excluded')->default(false);
            $table->text('excluded_notes')->nullable();
            $table->unsignedInteger('onboarding_status')->nullable();
            $table->foreign('onboarding_status')
                ->references('id')->on('cm_onboarding_statuses')
                ->onDelete('set null');
            $table->boolean('rental_upgrade')->nullable();
            $table->boolean('vacant_upgrade')->nullable();
            $table->boolean('foreclosure_upgrade')->nullable();

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
        Schema::connection('mysql_dev')->dropIfExists('cm_community_sales_configurations');
    }
}
