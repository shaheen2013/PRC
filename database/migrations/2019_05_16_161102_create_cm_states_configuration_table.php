<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCmStatesConfigurationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql_dev')->create('cm_state_config', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code');
            $table->string('name');
            $table->unsignedInteger('state_foreclosure_process')->nullable();
            $table->foreign('state_foreclosure_process', 'foreclosure_process')
                ->references('id')->on('cm_state_foreclosure_process_configs')
                ->onDelete('set null');
            $table->unsignedInteger('state_governance')->nullable();
            $table->foreign('state_governance')
                ->references('id')->on('cm_state_governance_options')
                ->onDelete('set null');
            $table->boolean('excluded')->default(false);
            $table->text('excluded_notes')->nullable();
            $table->integer('average_days_to_foreclosure')->nullable();
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
        Schema::connection('mysql_dev')->dropIfExists('cm_state_config');
    }
}
