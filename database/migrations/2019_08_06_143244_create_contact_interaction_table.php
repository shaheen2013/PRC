<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContactInteractionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql_dev')->create('cm_contact_interaction', function (Blueprint $table) {
            $table->primary(['contact_id', 'interaction_id']);
            $table->integer('contact_id')->unsigned()->nullable();
            $table->foreign('contact_id')->references('id')
                ->on('cm_contacts')->onDelete('cascade');

            $table->integer('interaction_id')->unsigned()->nullable();
            $table->foreign('interaction_id')->references('id')
                ->on('cm_interactions')->onDelete('cascade');

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
        Schema::connection('mysql_dev')->dropIfExists('cm_contact_interaction');
    }
}
